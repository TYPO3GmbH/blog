<?php
namespace T3G\AgencyPack\Blog\Service;

use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;

class CommentService
{
    protected $postRepository;
    protected $settings = [
        'active' => 0,
        'moderation' => 0
    ];

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

    public function addComment(Post $post, Comment $comment)
    {
        $result = 'error';
        if ((int)$this->settings['active'] === 1) {
            $result = 'success';
            if ((int)$this->settings['moderation'] === 1) {
                $result = 'moderation';
                $comment->setHidden(1);
            }
            $post->addComment($comment);
            $this->postRepository->update($post);
        }
        return $result;
    }
}