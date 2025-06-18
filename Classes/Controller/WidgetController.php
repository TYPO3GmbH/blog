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
use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Utility\ArchiveUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class WidgetController extends ActionController
{
    protected CategoryRepository $categoryRepository;
    protected TagRepository $tagRepository;
    protected PostRepository $postRepository;
    protected CommentRepository $commentRepository;
    protected CacheService $cacheService;

    public function __construct(
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        PostRepository $postRepository,
        CommentRepository $commentRepository,
        CacheService $cacheService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->cacheService = $cacheService;
    }

    public function categoriesAction(): ResponseInterface
    {
        // @todo allow post?
        $requestParameters = $this->request->getQueryParams()['tx_blog_category'] ?? [];
        $currentCategory = 0;
        if (($requestParameters['category'] ?? null) !== null) {
            $currentCategory = (int)$requestParameters['category'];
        }
        $categories = $this->categoryRepository->findAll();
        $this->view->assign('categories', $categories);
        $this->view->assign('currentCategory', $currentCategory);
        foreach ($categories as $category) {
            $this->cacheService->addTagToPage($this->request, 'tx_blog_category_' . $category->getUid());
        }
        return $this->htmlResponse();
    }

    public function tagsAction(): ResponseInterface
    {
        // @todo allow post?
        $requestParameters = $this->request->getQueryParams()['tx_blog_tag'] ?? [];
        $currentTag = 0;
        if (($requestParameters['tag'] ?? null) !== null) {
            $currentTag = (int)$requestParameters['tag'];
        }
        $limit = (int)($this->settings['widgets']['tags']['limit'] ?? 20);
        $minSize = (int)($this->settings['widgets']['tags']['minSize'] ?? 100);
        $maxSize = (int)($this->settings['widgets']['tags']['maxSize'] ?? 100);
        $tags = $this->tagRepository->findTopByUsage($limit);
        $minimumCount = null;
        $maximumCount = 0;
        foreach ($tags as $tag) {
            if ($tag['cnt'] > $maximumCount) {
                $maximumCount = $tag['cnt'];
            }
            if ($minimumCount === null || $tag['cnt'] < $minimumCount) {
                $minimumCount = $tag['cnt'];
            }
        }
        $spread = $maximumCount - $minimumCount;

        if ($spread === 0) {
            $spread = 1;
        }

        foreach ($tags as &$tagReference) {
            $size = $minSize + ($tagReference['cnt'] - $minimumCount) * ($maxSize - $minSize) / $spread;
            $tagReference['size'] = floor($size);
        }
        unset($tagReference);
        foreach ($tags as $tag) {
            $this->cacheService->addTagToPage($this->request, 'tx_blog_tag_' . (int)$tag['uid']);
        }
        $this->view->assign('tags', $tags);
        $this->view->assign('currentTag', $currentTag);
        return $this->htmlResponse();
    }

    public function recentPostsAction(): ResponseInterface
    {
        $limit = (int)($this->settings['widgets']['recentposts']['limit'] ?? 0);

        $posts = $limit > 0
            ? $this->postRepository->findAllWithLimit($limit)
            : $this->postRepository->findAll();

        foreach ($posts as $post) {
            $this->cacheService->addTagsForPost($this->request, $post);
        }
        $this->view->assign('posts', $posts);
        return $this->htmlResponse();
    }

    public function commentsAction(): ResponseInterface
    {
        $limit = (int)($this->settings['widgets']['comments']['limit'] ?? 5);
        $blogSetup = isset($this->settings['widgets']['comments']['blogSetup']) ? (int) $this->settings['widgets']['comments']['blogSetup'] : null;
        $comments = $this->commentRepository->findActiveComments($limit, $blogSetup);
        $this->view->assign('comments', $comments);
        foreach ($comments as $comment) {
            $this->cacheService->addTagToPage($this->request, 'tx_blog_comment_' . $comment->getUid());
        }
        return $this->htmlResponse();
    }

    public function archiveAction(): ResponseInterface
    {
        $posts = $this->postRepository->findMonthsAndYearsWithPosts();
        $this->view->assign('archiveData', ArchiveUtility::extractDataFromPosts($posts));
        return $this->htmlResponse();
    }

    public function feedAction(): ResponseInterface
    {
        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/xml; charset=utf-8');
        $response->getBody()->write($this->view->render());
        return $response;
    }
}
