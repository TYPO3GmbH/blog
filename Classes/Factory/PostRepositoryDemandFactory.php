<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Factory;

use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\DataTransferObject\PostRepositoryDemand;
use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PostRepositoryDemandFactory
{
    private $categoryRepository;
    private $tagRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    public function createFromSettings(array $settings): PostRepositoryDemand
    {
        $demand = new PostRepositoryDemand();
        $demand->setPosts(GeneralUtility::intExplode(',', $settings['posts'] ?? '', true));

        foreach ($this->categoryRepository->findByUids(GeneralUtility::intExplode(',', $settings['categories'] ?? '')) as $category) {
            $demand->addCategory($category);
        }

        if (in_array($settings['categoriesConjunction'] ?? null, [Constants::REPOSITORY_CONJUNCTION_AND, Constants::REPOSITORY_CONJUNCTION_OR], true)) {
            $demand->setCategoriesConjunction($settings['categoriesConjunction']);
        }

        foreach ($this->tagRepository->findByUids(GeneralUtility::intExplode(',', $settings['tags'] ?? '')) as $tag) {
            $demand->addTag($tag);
        }

        if (isset($GLOBALS['TCA']['pages']['columns'][$settings['sortBy']])) {
            $direction = strtoupper($settings['sortDirection'] ?? 'ASC');
            if (!in_array($direction, ['ASC', 'DESC'], true)) {
                $direction = 'ASC';
            }

            $demand->setOrdering($settings['sortBy'], $direction);
        }

        $demand->setLimit((int)($settings['limit'] ?? 0));

        return $demand;
    }
}
