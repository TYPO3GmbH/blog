<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

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

use T3G\AgencyPack\Blog\Domain\Model\Author;
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use T3G\AgencyPack\Blog\Domain\Repository\AuthorRepository;
use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Service\MetaService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\ArrayUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Posts related controller.
 */
class PostController extends ActionController
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
     * @var AuthorRepository
     */
    protected $authorRepository;

    /**
     * @var CacheService
     */
    protected $blogCacheService;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param TagRepository $tagRepository
     */
    public function injectTagRepository(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param AuthorRepository $authorRepository
     */
    public function injectAuthorRepository(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Service\CacheService $cacheService
     */
    public function injectBlogCacheService(CacheService $cacheService)
    {
        $this->blogCacheService = $cacheService;
    }

    /**
     * @param ViewInterface $view
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    protected function initializeView(ViewInterface $view)
    {
        parent::initializeView($view);
        if ($this->request->hasArgument('format') && $this->request->getArgument('format') === 'rss') {
            $action = '.' . $this->request->getArgument('action');
            $arguments = [];
            switch ($action) {
                case '.listPostsByCategory':
                    if (isset($this->arguments['category'])) {
                        $arguments[] = $this->arguments['category']->getValue()->getTitle();
                    }
                    break;
                case '.listPostsByDate':
                    $arguments[] = (int) $this->arguments['year']->getValue();
                    if (isset($this->arguments['month'])) {
                        $arguments[] = (int) $this->arguments['month']->getValue();
                    }
                    break;
                case '.listPostsByTag':
                    if (isset($this->arguments['tag'])) {
                        $arguments[] = $this->arguments['tag']->getValue()->getTitle();
                    }
                    break;
            }
            $feedData = [
                'title' => LocalizationUtility::translate('feed.title' . $action, 'blog', $arguments),
                'description' => LocalizationUtility::translate('feed.description' . $action, 'blog', $arguments),
                'language' => $GLOBALS['TSFE']->sys_language_isocode,
                'link' => $this->uriBuilder->setUseCacheHash(false)->setArgumentsToBeExcludedFromQueryString(['id'])->setCreateAbsoluteUri(true)->setAddQueryString(true)->build(),
                'date' => date('r'),
            ];
            $this->view->assign('feed', $feedData);
        }
    }

    /**
     * Show a list of recent posts.
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function listRecentPostsAction()
    {
        $maximumItems = (int)ArrayUtility::getValueByPath($this->settings, 'lists.posts.maximumDisplayedItems') ?: 0;

        $posts = (0 === $maximumItems)
            ? $this->postRepository->findAll()
            : $this->postRepository->findAllWithLimit($maximumItems);

        foreach ($posts as $post) {
            $this->blogCacheService->addTagsForPost($post);
        }

        $this->view->assign('posts', $posts);
    }

    /**
     * Shows a list of posts by given month and year.
     *
     * @param int $year
     * @param int $month
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \RuntimeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function listPostsByDateAction($year = null, $month = null)
    {
        if (null === $year) {
            // we need at least the year
            $this->redirect('listRecentPosts');
        }
        $timestamp = mktime(0, 0, 0, $month, 1, $year);
        $posts = $this->postRepository->findByMonthAndYear($year, $month);
        foreach ($posts as $post) {
            $this->blogCacheService->addTagsForPost($post);
        }
        $this->view->assignMultiple([
            'month' => $month,
            'year' => $year,
            'timestamp' => $timestamp,
            'posts' => $posts,
        ]);
        $title = str_replace([
            '###MONTH###',
            '###MONTH_NAME###',
            '###YEAR###',
        ], [
            $month,
            strftime('%B', $timestamp),
            $year,
        ], LocalizationUtility::translate('meta.title.listPostsByDate', 'blog'));
        MetaService::set(MetaService::META_TITLE, $title);
        MetaService::set(MetaService::META_DESCRIPTION, LocalizationUtility::translate('meta.description.listPostsByDate', 'blog'));
    }

    /**
     * Show a list of posts by given category.
     *
     * @param Category $category
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \RuntimeException
     */
    public function listPostsByCategoryAction(Category $category = null)
    {
        if (null === $category) {
            $this->view->assign('categories', $this->categoryRepository->findAll());
        } else {
            $posts = $this->postRepository->findAllByCategory($category);
            $this->view->assign('posts', $posts);
            $this->view->assign('category', $category);
            MetaService::set(MetaService::META_TITLE, $category->getTitle());
            MetaService::set(MetaService::META_DESCRIPTION, $category->getDescription());
            MetaService::set(MetaService::META_CATEGORIES, [$category->getTitle()]);
            foreach ($posts as $post) {
                $this->blogCacheService->addTagsForPost($post);
            }
        }
    }

    /**
     * Show a list of posts by given category.
     *
     * @param Author $author
     *
     * @throws \RuntimeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function listPostsByAuthorAction(Author $author = null)
    {
        if (null === $author) {
            $this->view->assign('authors', $this->authorRepository->findAll());
        } else {
            $posts = $this->postRepository->findAllByAuthor($author);
            $this->view->assign('posts', $posts);
            $this->view->assign('author', $author);
            MetaService::set(MetaService::META_TITLE, $author->getName());
            MetaService::set(MetaService::META_DESCRIPTION, $author->getBio());
            foreach ($posts as $post) {
                $this->blogCacheService->addTagsForPost($post);
            }
        }
    }

    /**
     * Show a list of posts by given tag.
     *
     * @param Tag $tag
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \RuntimeException
     */
    public function listPostsByTagAction(Tag $tag = null)
    {
        if (null === $tag) {
            $this->view->assign('tags', $this->tagRepository->findAll());
        } else {
            $posts = $this->postRepository->findAllByTag($tag);
            $this->view->assign('posts', $posts);
            $this->view->assign('tag', $tag);
            MetaService::set(MetaService::META_TITLE, $tag->getTitle());
            MetaService::set(MetaService::META_DESCRIPTION, $tag->getDescription());
            MetaService::set(MetaService::META_TAGS, [$tag->getTitle()]);
            foreach ($posts as $post) {
                $this->blogCacheService->addTagsForPost($post);
            }
        }
    }

    /**
     * Sidebar action.
     */
    public function sidebarAction()
    {
    }

    /**
     * Metadata action: output meta information of blog post.
     */
    public function metadataAction()
    {
        $post = $this->postRepository->findCurrentPost();
        $this->view->assign('post', $post);
        $this->blogCacheService->addTagsForPost($post);
    }

    /**
     * Authors action: output author information of blog post.
     */
    public function authorsAction()
    {
        $post = $this->postRepository->findCurrentPost();
        $this->view->assign('post', $post);
        $this->blogCacheService->addTagsForPost($post);
    }
}
