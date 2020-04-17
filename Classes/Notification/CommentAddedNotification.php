<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification;

use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Mail\MailContent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class CommentAddedNotification extends AbstractNotification
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        /** @var Post $post */
        $post = $this->data['post'];
        return sprintf(LocalizationUtility::translate('emails.CommentAddedNotification.subject', 'blog'), $post->getTitle());
    }

    /**
     * @return string
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     */
    public function getMessage(): string
    {
        /** @var Comment $comment */
        $comment = $this->data['comment'];

        /** @var Post $post */
        $post = $this->data['post'];

        $mailContent = GeneralUtility::makeInstance(MailContent::class);
        return $mailContent->render('CommentAdded', [
            'comment' => $comment,
            'post' => $post
        ]);
    }
}
