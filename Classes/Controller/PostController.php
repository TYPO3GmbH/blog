<?php
declare(strict_types = 1);

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
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use T3G\AgencyPack\Blog\Domain\Repository\AuthorRepository;
use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Service\MetaService;
use T3G\AgencyPack\Blog\Utility\ArchiveUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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
     * @param AuthorRepository $authorRepository
     */
    public function injectAuthorRepository(AuthorRepository $authorRepository): void
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Service\CacheService $cacheService
     */
    public function injectBlogCacheService(CacheService $cacheService): void
    {
        $this->blogCacheService = $cacheService;
    }

    /**
     * @param ViewInterface $view
     */
    protected function initializeView(ViewInterface $view): void
    {
        parent::initializeView($view);
        if ($this->request->getFormat() === 'rss') {
            $action = '.' . $this->request->getControllerActionName();
            $arguments = [];
            switch ($action) {
                case '.listPostsByCategory':
                    if (isset($this->arguments['category'])) {
                        $arguments[] = $this->arguments['category']->getValue()->getTitle();
                    }
                    break;
                case '.listPostsByDate':
                    $arguments[] = (int)$this->arguments['year']->getValue();
                    if (isset($this->arguments['month'])) {
                        $arguments[] = (int)$this->arguments['month']->getValue();
                    }
                    break;
                case '.listPostsByTag':
                    if (isset($this->arguments['tag'])) {
                        $arguments[] = $this->arguments['tag']->getValue()->getTitle();
                    }
                    break;
                case '.listPostsByAuthor':
                    if (isset($this->arguments['author'])) {
                        $arguments[] = $this->arguments['author']->getValue()->getName();
                    }
                    break;
                default:
            }
            $feedData = [
                'title' => LocalizationUtility::translate('feed.title' . $action, 'blog', $arguments),
                'description' => LocalizationUtility::translate('feed.description' . $action, 'blog', $arguments),
                'language' => $this->getTypoScriptFontendController()->sys_language_isocode,
                'link' => $this->uriBuilder->getRequest()->getRequestUri(),
                'date' => date('r'),
            ];
            $this->view->assign('feed', $feedData);
        }

        /** @extensionScannerIgnoreLine */
        $this->view->assign('data', $this->configurationManager->getContentObject()->data);
    }

    /**
     * Show a list of recent posts.
     *
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function listRecentPostsAction(): void
    {
        $maximumItems = (int) ($this->settings['lists']['posts']['maximumDisplayedItems'] ?? 0);
        $posts = (0 === $maximumItems)
            ? $this->postRepository->findAll()
            : $this->postRepository->findAllWithLimit($maximumItems);

        foreach ($posts as $post) {
            $this->blogCacheService->addTagsForPost($post);
        }

        $this->view->assign('posts', $posts);
    }

    /**
     * @param int $year
     * @param int $month
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \Exception
     */
    public function listPostsByDateAction(int $year = null, int $month = null): void
    {
        if ($year === null) {
            $posts = $this->postRepository->findMonthsAndYearsWithPosts();
            $this->view->assign('archiveData', ArchiveUtility::extractDataFromPosts($posts));
        } else {
            $dateTime = new \DateTimeImmutable(sprintf('%d-%d-1', $year, $month ?? 1));
            $posts = $this->postRepository->findByMonthAndYear($year, $month);
            foreach ($posts as $post) {
                $this->blogCacheService->addTagsForPost($post);
            }
            $this->view->assignMultiple([
                'month' => $month,
                'year' => $year,
                'timestamp' => $dateTime->getTimestamp(),
                'posts' => $posts,
            ]);
            $title = str_replace([
                '###MONTH###',
                '###MONTH_NAME###',
                '###YEAR###',
            ], [
                $month,
                $dateTime->format('F'),
                $year,
            ], LocalizationUtility::translate('meta.title.listPostsByDate', 'blog'));
            MetaService::set(MetaService::META_TITLE, $title);
            MetaService::set(MetaService::META_DESCRIPTION, LocalizationUtility::translate('meta.description.listPostsByDate', 'blog'));
        }
    }

    /**
     * Show a list of posts by given category.
     *
     * @param Category|null $category
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function listPostsByCategoryAction(Category $category = null): void
    {
        if ($category === null) {
            $categories = $this->categoryRepository->getByReference(
                'tt_content',
                $this->configurationManager->getContentObject()->data['uid']
            );

            if (!empty($categories)) {
                /** @noinspection CallableParameterUseCaseInTypeContextInspection */
                $category = $categories->getFirst();
            }
        }

        if ($category) {
            $posts = $this->postRepository->findAllByCategory($category);
            $this->view->assign('posts', $posts);
            $this->view->assign('category', $category);
            MetaService::set(MetaService::META_TITLE, $category->getTitle());
            MetaService::set(MetaService::META_DESCRIPTION, $category->getDescription());
            MetaService::set(MetaService::META_CATEGORIES, [$category->getTitle()]);
            foreach ($posts as $post) {
                $this->blogCacheService->addTagsForPost($post);
            }
        } else {
            $this->view->assign('categories', $this->categoryRepository->findAll());
        }
    }

    /**
     * Show a list of posts by given category.
     *
     * @param Author|null $author
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function listPostsByAuthorAction(Author $author = null): void
    {
        if ($author) {
            $posts = $this->postRepository->findAllByAuthor($author);
            $this->view->assign('posts', $posts);
            $this->view->assign('author', $author);
            MetaService::set(MetaService::META_TITLE, $author->getName());
            MetaService::set(MetaService::META_DESCRIPTION, $author->getBio());
            foreach ($posts as $post) {
                $this->blogCacheService->addTagsForPost($post);
            }
        } else {
            $this->view->assign('authors', $this->authorRepository->findAll());
        }
    }

    /**
     * Show a list of posts by given tag.
     *
     * @param Tag|null $tag
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function listPostsByTagAction(Tag $tag = null): void
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
    public function sidebarAction(): void
    {
    }

    /**
     * Metadata action: output meta information of blog post.
     *
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function metadataAction(): void
    {
        $post = $this->postRepository->findCurrentPost();
        $this->view->assign('post', $post);
        if ($post instanceof Post) {
            $this->blogCacheService->addTagsForPost($post);
        }
    }

    /**
     * Authors action: output author information of blog post.
     *
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function authorsAction(): void
    {
        $post = $this->postRepository->findCurrentPost();
        $this->view->assign('post', $post);
        if ($post instanceof Post) {
            $this->blogCacheService->addTagsForPost($post);
        }
    }

    /**
     * Related posts action: show related posts based on the current post
     *
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function relatedPostsAction(): void
    {
        $post = $this->postRepository->findCurrentPost();
        $posts = $this->postRepository->findRelatedPosts(
            (int)$this->settings['relatedPosts']['categoryMultiplier'],
            (int)$this->settings['relatedPosts']['tagMultiplier'],
            (int)$this->settings['relatedPosts']['limit']
        );
        $this->view->assign('currentPost', $post);
        $this->view->assign('posts', $posts);
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
