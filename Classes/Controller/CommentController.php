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
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Lang\LanguageService;

/**
 * Comment frontend
 *
 */
class CommentController extends ActionController
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @var CommentRepository
     */
    protected $commentRepository;

    /**
     * @param CommentRepository $commentRepository
     */
    public function injectCommentRepository(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * CommentController constructor.
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
     * Show comment form
     *
     * @param Post|null $post
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
     * Add comment to blog post
     *
     * @param Post $post
     * @param Comment $comment
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function addCommentAction(Post $post, Comment $comment)
    {
        $messageTitle = 'message.addComment.error.title';
        $messageText = 'message.addComment.error.text';
        $messageSeverity = FlashMessage::ERROR;
        if ((int)$this->settings['comments']['active'] === 1) {
            $messageTitle = 'message.addComment.success.title';
            $messageText = 'message.addComment.success.text';
            $messageSeverity = FlashMessage::OK;
            if ((int)$this->settings['comments']['moderation'] === 1) {
                $comment->setHidden(1);
                $messageTitle = 'message.addComment.moderation.title';
                $messageText = 'message.addComment.moderation.text';
                $messageSeverity = FlashMessage::INFO;
            }
            $post->addComment($comment);
            $this->postRepository->update($post);
            $this->clearCacheByPost($post);
        }
        $languageService = $this->getLanguageService();
        $this->addFlashMessage(
            $languageService->getLL($messageText),
            $languageService->getLL($messageTitle),
            $messageSeverity
        );
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
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

    /**
     * @return PersistenceManager
     * @throws \InvalidArgumentException
     */
    protected function getPersistenceManager()
    {
        return GeneralUtility::makeInstance(PersistenceManager::class);
    }
}
