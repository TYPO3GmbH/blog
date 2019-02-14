<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Controller;

use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Utility\ArchiveUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class WidgetController extends ActionController
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var CommentRepository
     */
    protected $commentRepository;

    /**
     * @var CacheService
     */
    protected $blogCacheService;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(CategoryRepository $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param TagRepository $tagRepository
     */
    public function injectTagRepository(TagRepository $tagRepository): void
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository): void
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param CommentRepository $commentRepository
     */
    public function injectCommentRepository(CommentRepository $commentRepository): void
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Service\CacheService $cacheService
     */
    public function injectBlogCacheService(CacheService $cacheService): void
    {
        $this->blogCacheService = $cacheService;
    }

    public function categoriesAction(): void
    {
        $requestParameters = GeneralUtility::_GP('tx_blog_category');
        $currentCategory = 0;
        if (!empty($requestParameters['category'])) {
            $currentCategory = (int)$requestParameters['category'];
        }
        $categories = $this->categoryRepository->findAll();
        $this->view->assign('categories', $categories);
        $this->view->assign('currentCategory', $currentCategory);
        foreach ($categories as $category) {
            $this->blogCacheService->addTagToPage('tx_blog_category_' . $category->getUid());
        }
    }

    public function tagsAction(): void
    {
        $limit = (int)$this->settings['widgets']['tags']['limit'] ?: 20;
        $minSize = (int)$this->settings['widgets']['tags']['minSize'] ?: 10;
        $maxSize = (int)$this->settings['widgets']['tags']['maxSize'] ?: 10;
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
            $this->blogCacheService->addTagToPage('tx_blog_tag_' . (int)$tag['uid']);
        }
        $this->view->assign('tags', $tags);
    }

    /**
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function recentPostsAction(): void
    {
        $limit = (int)$this->settings['widgets']['recentposts']['limit'] ?: 0;

        $posts = $limit > 0
            ? $this->postRepository->findAllWithLimit($limit)
            : $this->postRepository->findAll();

        foreach ($posts as $post) {
            $this->blogCacheService->addTagsForPost($post);
        }
        $this->view->assign('posts', $posts);
    }

    /**
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function commentsAction(): void
    {
        $limit = (int)$this->settings['widgets']['comments']['limit'] ?: 5;
        $blogSetup = (int)$this->settings['widgets']['comments']['blogSetup'] ?: null;
        $comments = $this->commentRepository->findActiveComments($limit, $blogSetup);
        $this->view->assign('comments', $comments);
        foreach ($comments as $comment) {
            $this->blogCacheService->addTagToPage('tx_blog_comment_' . $comment->getUid());
        }
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function archiveAction(): void
    {
        $posts = $this->postRepository->findMonthsAndYearsWithPosts();
        $this->view->assign('archiveData', ArchiveUtility::extractDataFromPosts($posts));
    }

    public function feedAction(): void
    {
    }
}
