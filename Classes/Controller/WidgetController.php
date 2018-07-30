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

use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Widget related controller.
 */
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
     * @param CommentRepository $commentRepository
     */
    public function injectCommentRepository(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     *
     */
    public function categoriesAction()
    {
        $this->view->assign('categories', $this->categoryRepository->findAll());
    }

    /**
     *
     */
    public function tagsAction()
    {
        $limit = (int) $this->settings['widgets']['tags']['limit'] ?: 20;
        $minSize = (int) $this->settings['widgets']['tags']['minSize'] ?: 10;
        $maxSize = (int) $this->settings['widgets']['tags']['maxSize'] ?: 10;
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
        $this->view->assign('tags', $tags);
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function recentPostsAction()
    {
        $limit = (int) $this->settings['widgets']['recentposts']['limit'] ?: 0;

        $posts = $limit > 0
            ? $this->postRepository->findAllWithLimit($limit)
            : $this->postRepository->findAll();

        $this->view->assign('posts', $posts);
    }

    /**
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function commentsAction()
    {
        $limit = (int) $this->settings['widgets']['comments']['limit'] ?: 5;
        $blogSetup = (int) $this->settings['widgets']['comments']['blogSetup'] ?: null;
        $this->view->assign('comments', $this->commentRepository->findActiveComments($limit, $blogSetup));
    }

    /**
     *
     */
    public function archiveAction()
    {
        $this->view->assign('archiveData', $this->resortArchiveData(
            $this->postRepository->findMonthsAndYearsWithPosts()
        ));
    }

    /**
     *
     */
    public function feedAction()
    {
    }

    /**
     * This method resort the database result and create a nested array
     * in the form:
     * [
     *  2015 => [
     *    [
     *      'year' => 2015,
     *      'month' => 3,
     *      'count' => 9
     *      'timestamp' => 123456789
     *    ]
     *    ...
     *  ]
     *  ...
     * ].
     *
     * @param array $data
     *
     * @return array
     */
    protected function resortArchiveData(array $data)
    {
        $archiveData = [];
        foreach ($data as $result) {
            if (empty($archiveData[$result['year']])) {
                $archiveData[$result['year']] = [];
            }
            $result['timestamp'] = mktime(0, 0, 0, (int) $result['month'], 1, (int) $result['year']);
            $archiveData[$result['year']][] = $result;
        }

        return $archiveData;
    }
}
