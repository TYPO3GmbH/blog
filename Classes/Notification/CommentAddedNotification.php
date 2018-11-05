<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification;

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

use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Messaging\MailMessage;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CommentAddedNotification
 */
class CommentAddedNotification extends AbstractNotification
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        /** @var Post $post */
        $post = $this->data['post'];
        return sprintf($this->getLanguageService()->sL('LLL:EXT:blog/Resources/Private/Language/locallang.xlf:emails.CommentAddedNotification.subject'), $post->getTitle());
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

        $mailMessage = GeneralUtility::makeInstance(MailMessage::class);
        return $mailMessage->render('CommentAdded', [
            'comment' => $comment,
            'post' => $post
        ]);
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
