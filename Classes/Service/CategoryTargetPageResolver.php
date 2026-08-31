<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Resolves the page a blog category has been assigned to.
 *
 * Categories may point to a regular page via the "blog_target_page" field.
 * Such pages are maintained by editors and allow to arrange additional
 * content around the post listing of a category. If a category does not
 * reference a page, the automatically generated category page of the blog
 * is used instead, which keeps the previous behaviour intact.
 */
class CategoryTargetPageResolver
{
    /**
     * @var array<int, int|null>
     */
    private array $resolvedPages = [];

    /**
     * Returns the page a category is assigned to or null if the category
     * relies on the automatically generated category page.
     */
    public function resolve(int $categoryUid): ?int
    {
        if ($categoryUid <= 0) {
            return null;
        }

        if (!array_key_exists($categoryUid, $this->resolvedPages)) {
            $this->resolvedPages[$categoryUid] = $this->determineTargetPage($categoryUid);
        }

        return $this->resolvedPages[$categoryUid];
    }

    private function determineTargetPage(int $categoryUid): ?int
    {
        $category = $this->fetchCategory($categoryUid);
        if ($category === null) {
            return null;
        }

        $pageUid = (int)($category['blog_target_page'] ?? 0);

        // Translated categories inherit the page of their default language record.
        if ($pageUid === 0 && (int)($category['l10n_parent'] ?? 0) > 0) {
            $defaultLanguageCategory = $this->fetchCategory((int)$category['l10n_parent']);
            $pageUid = (int)($defaultLanguageCategory['blog_target_page'] ?? 0);
        }

        if ($pageUid === 0 || !$this->isPageAvailable($pageUid)) {
            return null;
        }

        return $pageUid;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function fetchCategory(int $categoryUid): ?array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $queryBuilder->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $category = $queryBuilder
            ->select('blog_target_page', 'l10n_parent')
            ->from('sys_category')
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter($categoryUid, Connection::PARAM_INT)
                )
            )
            ->executeQuery()
            ->fetchAssociative();

        return $category === false ? null : $category;
    }

    /**
     * Hidden or expired pages must not be linked to, the automatically
     * generated category page is used for those categories instead.
     */
    private function isPageAvailable(int $pageUid): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');

        $page = $queryBuilder
            ->select('uid')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter($pageUid, Connection::PARAM_INT)
                )
            )
            ->executeQuery()
            ->fetchOne();

        return $page !== false;
    }
}
