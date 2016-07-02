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
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Posts related controller
 *
 */
class PostController extends ActionController
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Show a list of recent posts
     */
    public function listRecentPostsAction()
    {
        $this->view->assign('posts', $this->postRepository->findAll());
    }

    /**
     * Show a list of posts by given tag
     *
     * @param \T3G\AgencyPack\Blog\Domain\Model\Tag $tag
     */
    public function listPostsByTagAction(Tag $tag)
    {
    }

    /**
     * Show a list of posts by given category
     *
     * @param Category $category
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function listPostsByCategoryAction(Category $category)
    {
        $this->view->assign('posts', $this->postRepository->findAllByCategory($category));
        $this->view->assign('category', $category);
    }

    /**
     * Sidebar action
     */
    public function sidebarAction()
    {
    }

    /**
     * Metadata action: output meta information of blog post
     */
    public function metadataAction()
    {
        $this->view->assign('post', $this->postRepository->findCurrentPost());
    }

    /**
     *
     */
    public function widgetRecentPostsAction()
    {
        $this->view->assign('posts', $this->postRepository->findAll());
    }

    /**
     * Show single post
     *
     * @param Post $post
     */
    public function showAction(Post $post)
    {
        $this->view->assign('post', $post);
    }
}
