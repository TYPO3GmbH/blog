<?php

namespace T3G\AgencyPack\Blog\Hooks;

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Class DataHandlerHook
 */
class DataHandlerHook
{
    const TABLE_PAGES = 'pages';

    /**
     * @param string $status
     * @param string $table
     * @param string|int $id
     * @param array $fieldArray
     * @param DataHandler $pObj
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Core\Exception
     */
    public function processDatamap_afterDatabaseOperations($status, $table, $id, array $fieldArray, $pObj)
    {
        if ($table === self::TABLE_PAGES) {
            if (!MathUtility::canBeInterpretedAsInteger($id)) {
                $id = $pObj->substNEWwithIDs[$id];
            }

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);
            $queryBuilder->getRestrictions()->removeAll();
            $record = $queryBuilder
                ->select('*')
                ->from($table)
                ->where($queryBuilder->expr()->eq('uid', (int)$id))
                ->execute()
                ->fetch();
            if (!empty($record)) {
                $timestamp = $record['crdate'] ?? time();
                $queryBuilder
                    ->update($table)
                    ->set('crdate_month', date('n', $timestamp))
                    ->set('crdate_year', date('Y', $timestamp))
                    ->where($queryBuilder->expr()->eq('uid', (int)$id))
                    ->execute();
            }
        }
    }

}
