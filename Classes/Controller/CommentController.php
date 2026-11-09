<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Controller;

use Psr\Http\Message\ResponseInterface;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Service\CommentService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class CommentController extends ActionController
{
    protected PostRepository $postRepository;
    protected CommentService $commentService;
    protected CacheService $cacheService;

    public function __construct(
        PostRepository $postRepository,
        CommentService $commentService,
        CacheService $cacheService
    ) {
        $this->postRepository = $postRepository;
        $this->commentService = $commentService;
        $this->cacheService = $cacheService;
    }

    /**
     * Show comment form.
     */
    public function formAction(): ResponseInterface
    {
        $this->view->assign('post', $this->postRepository->findCurrentPost());
        return $this->htmlResponse();
    }

    public function commentsAction(): ResponseInterface
    {
        $post = $this->postRepository->findCurrentPost();
        if ($post instanceof Post) {
            $comments = $this->commentService->getCommentsByPost($post);
            foreach ($comments as $comment) {
                $this->cacheService->addTagToPage($this->request, 'tx_blog_comment_' . $comment->getUid());
            }
            $this->view->assign('comments', $comments);
            $this->view->assign('post', $post);
        }
        return $this->htmlResponse();
    }
}
