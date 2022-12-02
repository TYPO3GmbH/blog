<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates;

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * CategoryTypeUpdate
 */
class CategoryTypeUpdate implements UpgradeWizardInterface
{
    /**
    * @return string
    */
    public function getIdentifier(): string
    {
        return self::class;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return '[EXT:blog] Use Blog-Type for Categories';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }

    /**
     * @return bool
     */
    public function updateNecessary(): bool
    {
        $queryBuilderPages = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilderPages->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $pagesStatement = $queryBuilderPages
            ->select('uid')
            ->from('pages')
            ->where(
                $queryBuilderPages->expr()->andX(
                    $queryBuilderPages->expr()->eq('doktype', $queryBuilderPages->createNamedParameter(254, \PDO::PARAM_INT)),
                    $queryBuilderPages->expr()->eq('module', $queryBuilderPages->createNamedParameter('blog'))
                )
            )
            ->execute();
        $pages = [];
        while ($pageRecord = $pagesStatement->fetchAssociative()) {
            $pages[] = $pageRecord['uid'];
        }

        $queryBuilderCategories = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $queryBuilderCategories->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $elementCount = $queryBuilderCategories
            ->count('uid')
            ->from('sys_category')
            ->where(
                $queryBuilderCategories->expr()->andX(
                    $queryBuilderCategories->expr()->eq('record_type', $queryBuilderCategories->createNamedParameter(1, \PDO::PARAM_INT)),
                    $queryBuilderCategories->expr()->in('pid', $queryBuilderCategories->createNamedParameter($pages, Connection::PARAM_INT_ARRAY))
                )
            )
            ->execute()
            ->fetchOne();

        return (bool)$elementCount;
    }

    /**
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $queryBuilderPages = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilderPages->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $pagesStatement = $queryBuilderPages
            ->select('uid')
            ->from('pages')
            ->where(
                $queryBuilderPages->expr()->andX(
                    $queryBuilderPages->expr()->eq('doktype', $queryBuilderPages->createNamedParameter(254, \PDO::PARAM_INT)),
                    $queryBuilderPages->expr()->eq('module', $queryBuilderPages->createNamedParameter('blog'))
                )
            )
            ->execute();
        $pages = [];
        while ($pageRecord = $pagesStatement->fetchAssociative()) {
            $pages[] = $pageRecord['uid'];
        }

        $queryBuilderCategories = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $queryBuilderCategories->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $categoryStatement = $queryBuilderCategories
            ->select('uid', 'record_type')
            ->from('sys_category')
            ->where(
                $queryBuilderCategories->expr()->andX(
                    $queryBuilderCategories->expr()->eq('record_type', $queryBuilderCategories->createNamedParameter(Constants::CATEGORY_TYPE_DEFAULT, \PDO::PARAM_INT)),
                    $queryBuilderCategories->expr()->in('pid', $queryBuilderCategories->createNamedParameter($pages, Connection::PARAM_INT_ARRAY))
                )
            )
            ->execute();

        while ($categoryRecord = $categoryStatement->fetchAssociative()) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
            $queryBuilder
                ->update('sys_category')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int) $categoryRecord['uid'], \PDO::PARAM_INT))
                )
                ->set('record_type', Constants::CATEGORY_TYPE_BLOG);
            $queryBuilder->execute();
        }

        return true;
    }
}
