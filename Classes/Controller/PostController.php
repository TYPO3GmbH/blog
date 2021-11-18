<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Controller;

use T3G\AgencyPack\Blog\Domain\Model\Author;
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use T3G\AgencyPack\Blog\Domain\Repository\AuthorRepository;
use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use T3G\AgencyPack\Blog\Factory\PostRepositoryDemandFactory;
use T3G\AgencyPack\Blog\Pagination\BlogPagination;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Service\MetaTagService;
use T3G\AgencyPack\Blog\Utility\ArchiveUtility;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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
     * @var PostRepositoryDemandFactory
     */
    protected $postRepositoryDemandFactory;

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

    public function injectPostRepositoryDemandFactory(PostRepositoryDemandFactory $postRepositoryDemandFactory): void
    {
        $this->postRepositoryDemandFactory = $postRepositoryDemandFactory;
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
                'language' => $this->getSiteLanguage()->getTwoLetterIsoCode(),
                'link' => $this->getRequestUrl(),
                'date' => date('r'),
            ];
            $this->view->assign('feed', $feedData);
        }

        /** @extensionScannerIgnoreLine */
        $this->view->assign('data', $this->configurationManager->getContentObject()->data);
    }

    /**
     * Show a list of recent posts.
     */
    public function listRecentPostsAction(int $currentPage = 1)
    {
        $maximumItems = (int) ($this->settings['lists']['posts']['maximumDisplayedItems'] ?? 0);
        $posts = (0 === $maximumItems)
            ? $this->postRepository->findAll()
            : $this->postRepository->findAllWithLimit($maximumItems);
        $pagination = $this->getPagination($posts, $currentPage);

        $this->view->assign('type', 'recent');
        $this->view->assign('posts', $posts);
        $this->view->assign('pagination', $pagination);
    }

    /**
     * Show a list of posts for a selected category.
     */
    public function listByDemandAction()
    {
        $repositoryDemand = $this->postRepositoryDemandFactory->createFromSettings($this->settings['demand'] ?? []);

        $this->view->assign('type', 'demand');
        $this->view->assign('demand', $repositoryDemand);
        $this->view->assign('posts', $this->postRepository->findByRepositoryDemand($repositoryDemand));
        $this->view->assign('pagination', []);
    }

    /**
     * Show a number of latest posts.
     */
    public function listLatestPostsAction()
    {
        $maximumItems = (int) ($this->settings['latestPosts']['limit'] ?: 3);
        $posts = $this->postRepository->findAllWithLimit($maximumItems);

        $this->view->assign('type', 'latest');
        $this->view->assign('posts', $posts);
    }

    /**
     * All blog posts ordered by date
     */
    public function listPostsByDateAction(int $year = null, int $month = null, int $currentPage = 1)
    {
        if ($year === null) {
            $posts = $this->postRepository->findMonthsAndYearsWithPosts();
            $this->view->assign('archiveData', ArchiveUtility::extractDataFromPosts($posts));
        } else {
            $dateTime = new \DateTimeImmutable(sprintf('%d-%d-1', $year, $month ?? 1));
            $posts = $this->postRepository->findByMonthAndYear($year, $month);
            $pagination = $this->getPagination($posts, $currentPage);
            $this->view->assign('type', 'bydate');
            $this->view->assign('month', $month);
            $this->view->assign('year', $year);
            $this->view->assign('timestamp', $dateTime->getTimestamp());
            $this->view->assign('posts', $posts);
            $this->view->assign('pagination', $pagination);
            $title = str_replace([
                '###MONTH###',
                '###MONTH_NAME###',
                '###YEAR###',
            ], [
                $month,
                $dateTime->format('F'),
                $year,
            ], LocalizationUtility::translate('meta.title.listPostsByDate', 'blog'));
            MetaTagService::set(MetaTagService::META_TITLE, (string) $title);
            MetaTagService::set(MetaTagService::META_DESCRIPTION, (string) LocalizationUtility::translate('meta.description.listPostsByDate', 'blog'));
        }
    }

    /**
     * Show a list of posts by given category.
     */
    public function listPostsByCategoryAction(?Category $category = null, int $currentPage = 1)
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
            $pagination = $this->getPagination($posts, $currentPage);
            $this->view->assign('type', 'bycategory');
            $this->view->assign('posts', $posts);
            $this->view->assign('pagination', $pagination);
            $this->view->assign('category', $category);
            MetaTagService::set(MetaTagService::META_TITLE, (string) $category->getTitle());
            MetaTagService::set(MetaTagService::META_DESCRIPTION, (string) $category->getDescription());
        } else {
            $this->view->assign('categories', $this->categoryRepository->findAll());
        }
    }

    /**
     * Show a list of posts by given author.
     */
    public function listPostsByAuthorAction(?Author $author = null, int $currentPage = 1)
    {
        if ($author) {
            $posts = $this->postRepository->findAllByAuthor($author);
            $pagination = $this->getPagination($posts, $currentPage);
            $this->view->assign('type', 'byauthor');
            $this->view->assign('posts', $posts);
            $this->view->assign('pagination', $pagination);
            $this->view->assign('author', $author);
            MetaTagService::set(MetaTagService::META_TITLE, (string) $author->getName());
            MetaTagService::set(MetaTagService::META_DESCRIPTION, (string) $author->getBio());
        } else {
            $this->view->assign('authors', $this->authorRepository->findAll());
        }
    }

    /**
     * Show a list of posts by given tag.
     */
    public function listPostsByTagAction(?Tag $tag = null, int $currentPage = 1)
    {
        if ($tag) {
            $posts = $this->postRepository->findAllByTag($tag);
            $pagination = $this->getPagination($posts, $currentPage);
            $this->view->assign('type', 'bytag');
            $this->view->assign('posts', $posts);
            $this->view->assign('pagination', $pagination);
            $this->view->assign('tag', $tag);
            MetaTagService::set(MetaTagService::META_TITLE, (string) $tag->getTitle());
            MetaTagService::set(MetaTagService::META_DESCRIPTION, (string) $tag->getDescription());
        } else {
            $this->view->assign('tags', $this->tagRepository->findAll());
        }
    }

    /**
     * Sidebar action.
     */
    public function sidebarAction()
    {
    }

    /**
     * Header action: output the header of blog post.
     */
    public function headerAction()
    {
        $post = $this->postRepository->findCurrentPost();
        $this->view->assign('post', $post);
        if ($post instanceof Post) {
            $this->blogCacheService->addTagsForPost($post);
        }
    }

    /**
     * Footer action: output the footer of blog post.
     */
    public function footerAction()
    {
        $post = $this->postRepository->findCurrentPost();
        $this->view->assign('post', $post);
        if ($post instanceof Post) {
            $this->blogCacheService->addTagsForPost($post);
        }
    }

    /**
     * Metadata action: output meta information of blog post.
     *
     * @deprecated
     */
    public function metadataAction()
    {
        trigger_error(
            'Using \T3G\AgencyPack\Blog\Controller\PostController::metadataAction is deprecated. Use headerAction or footerAction instead.',
            E_USER_DEPRECATED
        );

        $post = $this->postRepository->findCurrentPost();
        $this->view->assign('post', $post);
        if ($post instanceof Post) {
            $this->blogCacheService->addTagsForPost($post);
        }
    }

    /**
     * Authors action: output author information of blog post.
     */
    public function authorsAction()
    {
        $post = $this->postRepository->findCurrentPost();
        $this->view->assign('post', $post);
        if ($post instanceof Post) {
            $this->blogCacheService->addTagsForPost($post);
        }
    }

    /**
     * Related posts action: show related posts based on the current post
     */
    public function relatedPostsAction()
    {
        $post = $this->postRepository->findCurrentPost();
        $posts = $this->postRepository->findRelatedPosts(
            (int)$this->settings['relatedPosts']['categoryMultiplier'],
            (int)$this->settings['relatedPosts']['tagMultiplier'],
            (int)$this->settings['relatedPosts']['limit']
        );
        $this->view->assign('type', 'related');
        $this->view->assign('post', $post);
        $this->view->assign('posts', $posts);
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }

    private function getSiteLanguage(): ?SiteLanguage
    {
        return $GLOBALS['TYPO3_REQUEST']->getAttribute('language');
    }

    private function getRequestUrl(): string
    {
        /** @var NormalizedParams $normalizedParams */
        $normalizedParams = $GLOBALS['TYPO3_REQUEST']->getAttribute('normalizedParams');
        return $normalizedParams->getRequestUrl();
    }

    protected function getPagination(QueryResultInterface $objects, int $currentPage = 1): ?BlogPagination
    {
        $maximumNumberOfLinks = (int) ($this->settings['lists']['pagination']['maximumNumberOfLinks'] ?? 0);
        $itemsPerPage = 10;
        if ($this->request->getFormat() === 'html') {
            $itemsPerPage = (int) ($this->settings['lists']['pagination']['itemsPerPage'] ?? 10);
        }

        $paginator = new QueryResultPaginator($objects, $currentPage, $itemsPerPage);
        return new BlogPagination($paginator, $maximumNumberOfLinks);
    }
}
