<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Factory;

use T3G\AgencyPack\Blog\Domain\Filter\Post\CategoryTag;
use T3G\AgencyPack\Blog\Domain\Filter\PostFilter;
use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;

/**
 * The post filter factory sets filter values from the request.
 */
class PostFilterFactory implements SingletonInterface
{
    protected CategoryRepository $categoryRepository;

    protected TagRepository $tagRepository;

    public function __construct(CategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    public function getFilterFromRequest(RequestInterface $request): PostFilter
    {
        // Currently there is only one filter implementation.
        $filter = new CategoryTag();
        if ($request->hasArgument('category')) {
            $filter->setCategory($this->categoryRepository->findByUid((int)$request->getArgument('category')));
        }
        if ($request->hasArgument('tag')) {
            $filter->setTag($this->tagRepository->findByUid((int)$request->getArgument('tag')));
        }
        return $filter;
    }
}
