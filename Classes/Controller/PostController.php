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

use T3G\AgencyPack\Blog\Domain\Model\Tag;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Posts related controller
 *
 */
class PostController extends ActionController
{
    /**
     * Show a list of recent posts
     */
    public function listRecentPostsAction()
    {
    }

    /**
     * Show a list of posts by given tag
     *
     * @param \T3G\AgencyPack\Blog\Domain\Model\Tag $tag
     */
    public function listPostsByTag(Tag $tag)
    {
    }

    /**
     * Show a list of posts by given category
     *
     * @param Category $category
     */
    public function listPostsByCategory(Category $category)
    {
    }

    /**
     * Search for posts
     *
     * @param Object $demand
     */
    public function searchAction($demand = null)
    {
    }
}
