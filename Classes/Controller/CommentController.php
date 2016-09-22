<?php

namespace T3G\AgencyPack\Blog\Controller;

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
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\CommentService;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Comment frontend.
 */
class CommentController extends ActionController
{
    /**
     * @var array
     */
    protected static $messages = [
        CommentService::STATE_ERROR => [
            'title' => 'message.addComment.error.title',
            'text' => 'message.addComment.error.text',
            'severity' => FlashMessage::ERROR,
        ],
        CommentService::STATE_MODERATION => [
            'title' => 'message.addComment.moderation.title',
            'text' => 'message.addComment.moderation.text',
            'severity' => FlashMessage::INFO,
        ],
        CommentService::STATE_SUCCESS => [
            'title' => 'message.addComment.success.title',
            'text' => 'message.addComment.success.text',
            'severity' => FlashMessage::OK,
        ],
    ];

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var CommentService
     */
    protected $commentService;

    /**
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Service\CommentService $commentService
     */
    public function injectCommentService(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @return bool
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }

    /**
     * Show comment form.
     *
     * @param Post|null    $post
     * @param Comment|null $comment
     */
    public function formAction(Post $post = null, Comment $comment = null)
    {
        if ($post === null) {
            $post = $this->postRepository->findCurrentPost();
        }
        $this->view->assign('post', $post);
        $this->view->assign('comment', $comment);
    }

    /**
     * Add comment to blog post.
     *
     * @param Post    $post
     * @param Comment $comment
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \RuntimeException
     */
    public function addCommentAction(Post $post, Comment $comment)
    {
        $this->commentService->injectSettings($this->settings['comments']);
        $state = $this->commentService->addComment($post, $comment);
        $this->addFlashMessage(
            LocalizationUtility::translate(self::$messages[$state]['text'], 'blog'),
            LocalizationUtility::translate(self::$messages[$state]['title'], 'blog'),
            self::$messages[$state]['severity']
        );
        $this->clearCacheByPost($post);
        $this->redirectToUri(
            $this->controllerContext
                ->getUriBuilder()
                ->reset()
                ->setTargetPageUid($post->getUid())
                ->buildFrontendUri()
        );
    }

    /**
     *
     */
    public function commentsAction()
    {
        $post = $this->postRepository->findCurrentPost();
        if ($post instanceof Post) {
            $this->view->assign('comments', $post->getComments());
        }
    }

    /**
     * @param Post $post
     *
     * @throws \InvalidArgumentException
     */
    protected function clearCacheByPost(Post $post)
    {
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->clear_cacheCmd($post->getUid());
    }
}
