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
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Service\CommentService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class CommentController extends ActionController
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var CommentService
     */
    protected $commentService;

    /**
     * @var CacheService
     */
    protected $blogCacheService;

    /**
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository): void
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Service\CommentService $commentService
     */
    public function injectCommentService(CommentService $commentService): void
    {
        $this->commentService = $commentService;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Service\CacheService $cacheService
     */
    public function injectBlogCacheService(CacheService $cacheService): void
    {
        $this->blogCacheService = $cacheService;
    }

    /**
     * Show comment form.
     *
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function formAction(): ResponseInterface
    {
        $this->view->assign('post', $this->postRepository->findCurrentPost());
        return $this->htmlResponse();
    }

    /**
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function commentsAction(): ResponseInterface
    {
        $post = $this->postRepository->findCurrentPost();
        if ($post instanceof Post) {
            $comments = $this->commentService->getCommentsByPost($post);
            foreach ($comments as $comment) {
                $this->blogCacheService->addTagToPage('tx_blog_comment_' . $comment->getUid());
            }
            $this->view->assign('comments', $comments);
            $this->view->assign('post', $post);
        }
        return $this->htmlResponse();
    }
}
