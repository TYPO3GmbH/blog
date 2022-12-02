<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service;

use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Class CommentService.
 */
class CommentService
{
    public const STATE_ERROR = 'error';
    public const STATE_MODERATION = 'moderation';
    public const STATE_SUCCESS = 'success';

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var CommentRepository
     */
    protected $commentRepository;

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @var array
     */
    protected $settings = [
        'active' => 0,
        'moderation' => 0,
    ];

    /**
     * @param array $settings
     */
    public function injectSettings(array $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Domain\Repository\PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository): void
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Domain\Repository\CommentRepository $commentRepository
     */
    public function injectCommentRepository(CommentRepository $commentRepository): void
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param PersistenceManager $persistenceManager
     */
    public function injectPersistenceManager(PersistenceManager $persistenceManager): void
    {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * @param Post $post
     * @param Comment $comment
     * @return string
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function addComment(Post $post, Comment $comment): string
    {
        $result = self::STATE_ERROR;
        if ((int)$this->settings['active'] === 1) {
            $result = self::STATE_SUCCESS;
            switch ((int)$this->settings['moderation']) {
                case 0:
                    $comment->setStatus(Comment::STATUS_APPROVED);
                    break;
                case 1:
                    $result = self::STATE_MODERATION;
                    $comment->setStatus(Comment::STATUS_PENDING);
                    break;
                case 2:
                    if ($this->approvedCommentExistsForSameEmail($comment)) {
                        $comment->setStatus(Comment::STATUS_APPROVED);
                    } else {
                        $result = self::STATE_MODERATION;
                        $comment->setStatus(Comment::STATUS_PENDING);
                    }
                    break;
                default:
            }
            $comment->setPid($post->getUid());
            /** @noinspection PhpUnhandledExceptionInspection */
            $comment->setPostLanguageId(GeneralUtility::makeInstance(Context::class)->getAspect('language')->getId());
            $post->addComment($comment);
            $this->postRepository->update($post);
            $this->persistenceManager->persistAll();
        }

        return $result;
    }

    /**
     * This method checks if an comment exists for the same email
     * address in the given comment.
     *
     * @param Comment $comment
     * @return bool
     */
    protected function approvedCommentExistsForSameEmail(Comment $comment): bool
    {
        $query = $this->commentRepository->createQuery();
        return $query->matching(
            $query->logicalAnd(
                $query->equals('email', $comment->getEmail()),
                $query->equals('status', Comment::STATUS_APPROVED)
            )
        )->execute()->count() > 0;
    }

    /**
     * @param Post $post
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getCommentsByPost(Post $post)
    {
        return $this->commentRepository->findAllByPost($post);
    }
}
