<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification\Processor;

use T3G\AgencyPack\Blog\Mail\MailMessage;
use T3G\AgencyPack\Blog\Notification\CommentAddedNotification;
use T3G\AgencyPack\Blog\Notification\NotificationInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class AdminNotificationProcessor implements ProcessorInterface
{
    public function process(NotificationInterface $notification): void
    {
        $notificationId = $notification->getNotificationId();

        if ($notificationId === CommentAddedNotification::class) {
            $this->processCommentAddNotification($notification);
        }
    }

    protected function processCommentAddNotification(NotificationInterface $notification): void
    {
        $notificationId = $notification->getNotificationId();
        $settings = GeneralUtility::makeInstance(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');

        if ((int)$settings['notifications'][$notificationId]['admin']['_typoScriptNodeValue'] === 1) {
            $emailAddresses = GeneralUtility::trimExplode(',', $settings['notifications'][$notificationId]['admin']['email']);
            $mail = GeneralUtility::makeInstance(MailMessage::class);
            $mail
                ->setSubject($notification->getTitle())
                ->setBody($notification->getMessage())
                ->setFrom([$settings['notifications']['email']['senderMail'] => $settings['notifications']['email']['senderName']])
                ->setTo($emailAddresses)
                ->send();
        }
    }
}
