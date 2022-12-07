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
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use /** @noinspection PhpInternalEntityUsedInspection */
    TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Migrate "crdate" into "publish_date" field for existing blog posts
 */
class DatabasePublishDateUpdate implements UpgradeWizardInterface
{
    /**
     * Return the identifier for this wizard
     * This should be the same string as used in the ext_localconf class registration
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'T3G\AgencyPack\Blog\Install\Updates\DatabasePublishDateUpdate';
    }

    /**
     * Return the speaking name of this wizard
     *
     * @return string
     */
    public function getTitle(): string
    {
        return '[EXT:blog] Set publish date fields to crdate for existing blog posts';
    }

    /**
     * Return the description for this wizard
     *
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     *
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('pages');
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();
        $statement = $queryBuilder->select('uid', 'crdate', 'publish_date')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq(
                        'doktype',
                        $queryBuilder->createNamedParameter(Constants::DOKTYPE_BLOG_POST, \PDO::PARAM_INT)
                    ),
                    $queryBuilder->expr()->eq('publish_date', 0)
                )
            )
            ->execute();
        while ($record = $statement->fetchAssociative()) {
            $timestamp = $record['crdate'] ?? time();
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder->update('pages')
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                    )
                )
                ->set('publish_date', $timestamp);
            $databaseQueries[] = $queryBuilder->getSQL();
            $queryBuilder->execute();
        }
        return true;
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool
     */
    public function updateNecessary(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');
        $tableColumns = $connection->getSchemaManager()->listTableColumns('pages');
        if (!isset($tableColumns['publish_date'])) {
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
                    $queryBuilder->expr()->eq('publish_date', 0)
                )
            )
            ->execute()
            ->fetchOne();
        return (bool)$elementCount;
    }

    /**
     * Returns an array of class names of Prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        /** @noinspection PhpInternalEntityUsedInspection */
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }
}
