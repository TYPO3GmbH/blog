<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Install\Updates;

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

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\AbstractUpdate;

/**
 * Migrate "crdate_month" and "crdate_year" field for existing blog posts
 */
class DatabaseMonthYearUpdate extends AbstractUpdate
{
    /**
     * @var string
     */
    protected $title = '[EXT:blog] Set new month and year fields for existing blog posts';

    /**
     * Checks if an update is needed
     *
     * @param string &$description The description for the update
     *
     * @return bool Whether an update is needed (TRUE) or not (FALSE)
     * @throws \InvalidArgumentException
     */
    public function checkForUpdate(&$description) : bool
    {
        if ($this->isWizardDone()) {
            return false;
        }
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');
        $tableColumns = $connection->getSchemaManager()->listTableColumns('pages');
        if (!isset($tableColumns['crdate_month']) && !isset($tableColumns['crdate_year'])) {
            return false;
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll();
        $elementCount = $queryBuilder
            ->count('uid')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq(
                        'doktype',
                        $queryBuilder->createNamedParameter(Constants::DOKTYPE_BLOG_POST, \PDO::PARAM_INT)
                    ),
                    $queryBuilder->expr()->eq('crdate_month', 0),
                    $queryBuilder->expr()->eq('crdate_year', 0)
                )
            )
            ->execute()
            ->fetchColumn();
        return (bool)$elementCount;
    }

    /**
     * Performs the database update
     *
     * @param array &$databaseQueries Queries done in this update
     * @param string &$customMessage Custom message
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function performUpdate(array &$databaseQueries, &$customMessage) : bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('pages');
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();
        $statement = $queryBuilder->select('uid', 'crdate')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq(
                        'doktype',
                        $queryBuilder->createNamedParameter(Constants::DOKTYPE_BLOG_POST, \PDO::PARAM_INT)
                    ),
                    $queryBuilder->expr()->eq('crdate_month', 0),
                    $queryBuilder->expr()->eq('crdate_year', 0)
                )
            )
            ->execute();
        while ($record = $statement->fetch()) {
            $timestamp = $record['crdate'] ?? time();
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder->update('pages')
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                    )
                )
                ->set('crdate_month', date('n', (int)$timestamp))
                ->set('crdate_year', date('Y', (int)$timestamp));
            $databaseQueries[] = $queryBuilder->getSQL();
            $queryBuilder->execute();
        }
        $this->markWizardAsDone();
        return true;
    }
}
