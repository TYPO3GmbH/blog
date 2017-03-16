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
            if ((int) $this->settings['moderation'] === 1) {
                $result = self::STATE_MODERATION;
                $comment->setStatus(Comment::STATUS_PENDING);
            } else {
                $comment->setStatus(Comment::STATUS_APPROVED);
            }
            $comment->setPostLanguageId($GLOBALS['TSFE']->sys_language_uid);
            $post->addComment($comment);
            $this->postRepository->update($post);
        }

        return $result;
    }

    /**
     * @param Post $post
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getCommentsByPost(Post $post)
    {
        return $this->commentRepository->findAllByPost($post);
    }
}
