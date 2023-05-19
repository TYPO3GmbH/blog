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
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

/**
 * Class CommentService.
 */
class CommentService
{
    public const STATE_ERROR = 'error';
    public const STATE_MODERATION = 'moderation';
    public const STATE_SUCCESS = 'success';

    protected PostRepository $postRepository;
    protected CommentRepository $commentRepository;
    protected PersistenceManagerInterface $persistenceManager;

    public function __construct(
        PostRepository $postRepository,
        CommentRepository $commentRepository,
        PersistenceManagerInterface $persistenceManager
    ) {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->persistenceManager = $persistenceManager;
    }

    protected array $settings = [
        'active' => 0,
        'moderation' => 0,
    ];

    public function setSettings(array $settings): void
    {
        $this->settings = $settings;
    }

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
     */
    protected function approvedCommentExistsForSameEmail(Comment $comment): bool
    {
        $query = $this->commentRepository->createQuery();
        return $query->matching(
            $query->logicalAnd([
                $query->equals('email', $comment->getEmail()),
                $query->equals('status', Comment::STATUS_APPROVED)
            ])
        )->execute()->count() > 0;
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getCommentsByPost(Post $post)
    {
        return $this->commentRepository->findAllByPost($post);
    }
}
