<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification\Processor;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use T3G\AgencyPack\Blog\Domain\Model\Author;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Notification\CommentAddedNotification;
use T3G\AgencyPack\Blog\Notification\NotificationInterface;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class AuthorNotificationProcessor implements ProcessorInterface
{

    /**
     * Process the notification
     *
     * @param NotificationInterface $notification
     * @throws \InvalidArgumentException
     */
    public function process(NotificationInterface $notification)
    {
        $notificationId = $notification->getNotificationId();

        if ($notificationId === CommentAddedNotification::class) {
            $this->processCommentAddNotification($notification);
        }
    }

    /**
     * @param NotificationInterface $notification
     * @throws \InvalidArgumentException
     */
    protected function processCommentAddNotification(NotificationInterface $notification): void
    {
        $notificationId = $notification->getNotificationId();

        $settings = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');

        /** @var Post $post */
        $post = $notification->getData()['post'];
        if ((int)$settings['notifications'][$notificationId]['author'] === 1) {
            /** @var Author $author */
            foreach ($post->getAuthors() as $author) {
                $mail = GeneralUtility::makeInstance(MailMessage::class);
                $mail
                    ->setSubject($notification->getTitle())
                    ->setBody($notification->getMessage(), 'text/html')
                    ->setFrom([$settings['notifications']['email']['senderMail'] => $settings['notifications']['email']['senderName']])
                    ->setTo([$author->getEmail()])
                    ->send();
            }
        }
    }
}
