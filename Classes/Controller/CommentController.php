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
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Lang\LanguageService;

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
     * CommentController constructor.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function __construct()
    {
        parent::__construct();
        $this->getLanguageService()->includeLLFile('EXT:blog/Resources/Private/Language/locallang.xlf');
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
        $languageService = $this->getLanguageService();
        $this->addFlashMessage(
            $languageService->getLL(self::$messages[$state]['text']),
            $languageService->getLL(self::$messages[$state]['title']),
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
     * @param Post|null $post
     */
    public function commentsAction(Post $post = null)
    {
        if ($post === null) {
            $post = $this->postRepository->findCurrentPost();
        }
        $this->view->assign('post', $post);
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

    /**
     * @return LanguageService
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    protected function getLanguageService()
    {
        if ($GLOBALS['LANG'] === null) {
            $GLOBALS['LANG'] = GeneralUtility::makeInstance(LanguageService::class);
            $GLOBALS['LANG']->init($GLOBALS['TSFE']->tmpl->setup['config.']['language']);
        }

        return $GLOBALS['LANG'];
    }

    /**
     * @return PersistenceManager
     *
     * @throws \InvalidArgumentException
     */
    protected function getPersistenceManager()
    {
        return GeneralUtility::makeInstance(PersistenceManager::class);
    }
}
