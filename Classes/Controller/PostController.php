<?php

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

use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\MetaService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Lang\LanguageService;

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
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Show a list of recent posts.
     */
    public function listRecentPostsAction()
    {
        $this->view->assign('posts', $this->postRepository->findAll());
    }

    /**
     * Initializes the controller before invoking an action method.
     *
     * Override this method to solve tasks which all actions have in
     * common.
     *
     * @return void
     * @api
     */
    protected function initializeAction()
    {
        parent::initializeAction();
        $this->getLanguageService()->includeLLFile('EXT:blog/Resources/Private/Language/locallang.xlf');
    }

    /**
     * Shows a list of posts by given month and year.
     *
     * @param int $year
     * @param int $month
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \RuntimeException
     */
    public function listPostsByDateAction($year, $month = null)
    {
        $timestamp = mktime(0, 0, 0, $month, 1, $year);
        $this->view->assignMultiple([
            'month' => $month,
            'year' => $year,
            'timestamp' => $timestamp,
            'posts' => $this->postRepository->findByMonthAndYear($year, $month),
        ]);
        $title = str_replace([
            '###MONTH###',
            '###MONTH_NAME###',
            '###YEAR###'
        ], [
            $month,
            strftime('%B', $timestamp),
            $year
        ], $this->getLanguageService()->getLL('meta.title.listPostsByDate'));
        MetaService::set(MetaService::META_TITLE, $title);
        MetaService::set(MetaService::META_DESCRIPTION, $this->getLanguageService()->getLL('meta.description.listPostsByDate'));
    }

    /**
     * Show a list of posts by given category.
     *
     * @param Category $category
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \RuntimeException
     */
    public function listPostsByCategoryAction(Category $category)
    {
        $this->view->assign('posts', $this->postRepository->findAllByCategory($category));
        $this->view->assign('category', $category);
        MetaService::set(MetaService::META_TITLE, $category->getTitle());
        MetaService::set(MetaService::META_DESCRIPTION, $category->getDescription());
        MetaService::set(MetaService::META_CATEGORIES, [$category->getTitle()]);
    }

    /**
     * Show a list of posts by given tag.
     *
     * @param Tag $tag
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \RuntimeException
     */
    public function listPostsByTagAction(Tag $tag)
    {
        $this->view->assign('posts', $this->postRepository->findAllByTag($tag));
        $this->view->assign('tag', $tag);
        MetaService::set(MetaService::META_TITLE, $tag->getTitle());
        MetaService::set(MetaService::META_DESCRIPTION, $tag->getDescription());
        MetaService::set(MetaService::META_TAGS, [$tag->getTitle()]);
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
        $this->view->assign('post', $this->postRepository->findCurrentPost());
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}
