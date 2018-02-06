<?php

namespace T3G\AgencyPack\Blog\Service;

use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;

/**
 * Class CommentService.
 */
class CommentService
{
    const STATE_ERROR = 'error';
    const STATE_MODERATION = 'moderation';
    const STATE_SUCCESS = 'success';

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var CommentRepository
     */
    protected $commentRepository;

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
    public function injectSettings(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Domain\Repository\PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Domain\Repository\CommentRepository $commentRepository
     */
    public function injectCommentRepository(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param Post    $post
     * @param Comment $comment
     *
     * @return string
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function addComment(Post $post, Comment $comment)
    {
        $result = self::STATE_ERROR;
        if ((int) $this->settings['active'] === 1) {
            $result = self::STATE_SUCCESS;
            switch ((int) $this->settings['moderation']) {
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
            }
            $comment->setPid($post->getUid());
            $comment->setPostLanguageId($GLOBALS['TSFE']->sys_language_uid);
            $post->addComment($comment);
            $this->postRepository->update($post);
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
            $query->logicalAnd([
                $query->equals('email', $comment->getEmail()),
                $query->equals('status', Comment::STATUS_APPROVED)
            ])
        )->execute()->count() > 0;
    }

    /**
     * @param Post $post
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getCommentsByPost(Post $post)
    {
        return $this->commentRepository->findAllByPost($post);
    }
}
