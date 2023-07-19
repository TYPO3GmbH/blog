<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Hooks;

use T3G\AgencyPack\Blog\Service\CacheService;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Class DataHandlerHook
 */
class DataHandlerHook
{
    private const TABLE_PAGES = 'pages';
    private const TABLE_CATEGORIES = 'sys_category';
    private const TABLE_AUTHORS = 'tx_blog_domain_model_author';
    private const TABLE_COMMENTS = 'tx_blog_domain_model_comment';
    private const TABLE_TAGS = 'tx_blog_domain_model_tag';

    /**
     * @param string|int $id
     */
    public function processDatamap_afterDatabaseOperations(string $status, string $table, $id, array $fieldValues, DataHandler $dataHandler): void
    {
        if ($table === self::TABLE_PAGES) {
            if (!MathUtility::canBeInterpretedAsInteger($id)) {
                $id = $dataHandler->substNEWwithIDs[$id];
            }

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);
            $queryBuilder->getRestrictions()->removeAll();
            $publishDate = $queryBuilder
                ->select('publish_date')
                ->from($table)
                ->where($queryBuilder->expr()->eq('uid', (int)$id))
                ->executeQuery()
                ->fetchOne();
            if ($publishDate !== false) {
                $timestamp = (int) ($publishDate !== 0 ? $publishDate : time());
                $queryBuilder
                    ->update($table)
                    ->set('publish_date', $timestamp)
                    ->set('crdate_month', date('n', (int)$timestamp))
                    ->set('crdate_year', date('Y', (int)$timestamp))
                    ->where($queryBuilder->expr()->eq('uid', (int)$id))
                    ->executeStatement();
            }
        }

        // Clear caches if required
        switch ($table) {
            case self::TABLE_PAGES:
                GeneralUtility::makeInstance(CacheService::class)
                    ->flushCacheByTag('tx_blog_post_' . $id);
                break;
            case self::TABLE_CATEGORIES:
                GeneralUtility::makeInstance(CacheService::class)
                    ->flushCacheByTag('tx_blog_category_' . $id);
                break;
            case self::TABLE_AUTHORS:
                GeneralUtility::makeInstance(CacheService::class)
                    ->flushCacheByTag('tx_blog_author_' . $id);
                break;
            case self::TABLE_COMMENTS:
                GeneralUtility::makeInstance(CacheService::class)
                    ->flushCacheByTag('tx_blog_comment_' . $id);
                break;
            case self::TABLE_TAGS:
                GeneralUtility::makeInstance(CacheService::class)
                    ->flushCacheByTag('tx_blog_tag_' . $id);
                break;
            default:
        }
    }
}
