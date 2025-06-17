<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification\Processor;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Mail\MailMessage;
use T3G\AgencyPack\Blog\Notification\CommentAddedNotification;
use T3G\AgencyPack\Blog\Notification\NotificationInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AuthorNotificationProcessor implements ProcessorInterface
{
    public function process(ServerRequestInterface $request, NotificationInterface $notification): void
    {
        $notificationId = $notification->getNotificationId();

        if ($notificationId === CommentAddedNotification::class) {
            $this->processCommentAddNotification($request, $notification);
        }
    }

    protected function processCommentAddNotification(ServerRequestInterface $request, NotificationInterface $notification): void
    {
        $settings = $request->getAttribute('site')->getSettings();

        /** @var Post $post */
        $post = $notification->getData()['post'];
        if ($settings->get('plugin.tx_blog.settings.notifications.CommentAddedNotification.author.enable') ?? false) {
            /** @var Author $author */
            foreach ($post->getAuthors() as $author) {
                $mail = GeneralUtility::makeInstance(MailMessage::class);
                $mail
                    ->setSubject($notification->getTitle())
                    ->setBody($notification->getMessage())
                    ->setFrom([$settings->get('plugin.tx_blog.settings.notifications.email.senderMail')])
                    ->setTo([$author->getEmail()])
                    ->send();
            }
        }
    }
}
