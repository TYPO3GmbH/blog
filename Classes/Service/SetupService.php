<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service;

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;

class SetupService
{
    public function determineBlogSetups(): array
    {
        $setups = [];
        $queryBuilder = $this->getQueryBuilderForTable('pages');
        $blogRootPages = $queryBuilder
            ->select('pid')
            ->addSelectLiteral($queryBuilder->expr()->count('pid', 'cnt'))
            ->from('pages')
            ->where($queryBuilder->expr()->eq('doktype', $queryBuilder->createNamedParameter(Constants::DOKTYPE_BLOG_POST, Connection::PARAM_INT)))
            ->groupBy('pid')
            ->executeQuery()
            ->fetchAllAssociative();
        foreach ($blogRootPages as $blogRootPage) {
            $blogUid = $blogRootPage['pid'];
            if (!array_key_exists($blogUid, $setups)) {
                $queryBuilder = $this->getQueryBuilderForTable('pages');
                $title = $queryBuilder
                    ->select('title')
                    ->from('pages')
                    ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($blogUid, Connection::PARAM_INT)))
                    ->executeQuery()
                    ->fetchOne();
                $rootline = array_reverse(GeneralUtility::makeInstance(RootlineUtility::class, $blogUid)->get());
                $setups[$blogUid] = [
                    'uid' => $blogUid,
                    'title' => $title,
                    'path' => implode(' / ', array_map(function ($page) {
                        return $page['title'];
                    }, $rootline)),
                    'rootline' => $rootline,
                    'articleCount' => $blogRootPage['cnt'],
                ];
            }
        }

        return $setups;
    }

    public function createBlogSetup(array $data = []): void
    {
        $title = array_key_exists('title', $data) ? (string)$data['title'] : null;
        $recordUidArray = [];

        $blogSetup = require GeneralUtility::getFileAbsFileName('EXT:blog/Configuration/DataHandler/BlogSetupRecords.php');
        if ($title !== null) {
            $blogSetup['pages']['NEW_blogRoot']['title'] = $title;
        }
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->start($blogSetup, []);
        $dataHandler->process_datamap();
        $recordUidArray = array_merge_recursive($recordUidArray, $dataHandler->substNEWwithIDs);

        // Update page id in PageTSConfig
        $blogRootUid = (int)$recordUidArray['NEW_blogRoot'];
        $blogFolderUid = (int)$recordUidArray['NEW_blogFolder'];
        $queryBuilder = $this->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll();
        $record = $queryBuilder
            ->select('TSconfig')
            ->from('pages')
            ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($blogRootUid, Connection::PARAM_INT)))
            ->executeQuery()
            ->fetchAssociative();
        $queryBuilder->update('pages')
            ->set('TSconfig', str_replace('NEW_blogFolder', (string)$blogFolderUid, $record['TSconfig'] ?? ''))
            ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($blogRootUid, Connection::PARAM_INT)))
            ->executeStatement();

        // Relations
        $blogSetupRelations = require GeneralUtility::getFileAbsFileName('EXT:blog/Configuration/DataHandler/BlogSetupRelations.php');
        $blogSetupRelations = $this->replaceNewUids($blogSetupRelations, $recordUidArray);
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->start($blogSetupRelations, []);
        $dataHandler->process_datamap();
        $recordUidArray = array_merge_recursive($recordUidArray, $dataHandler->substNEWwithIDs);

        // Replace UIDs in constants
        $sysTemplateUid = (int)$recordUidArray['NEW_SysTemplate'];
        $queryBuilder = $this->getQueryBuilderForTable('sys_template');
        $record = $queryBuilder
            ->select('constants')
            ->from('sys_template')
            ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($sysTemplateUid, Connection::PARAM_INT)))
            ->executeQuery()
            ->fetchAssociative();
        $queryBuilder
            ->update('sys_template')
            ->set('constants', str_replace(
                array_keys($recordUidArray),
                $recordUidArray,
                $record['constants'] ?? ''
            ))
            ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($sysTemplateUid, Connection::PARAM_INT)))
            ->executeStatement();

        BackendUtility::setUpdateSignal('updatePageTree');
    }

    protected function replaceNewUids(array $setup, array $recordUidArray): array
    {
        $newSetup = [];
        foreach ($setup as $key => &$value) {
            if (strpos($key, 'NEW') !== false) {
                foreach ($recordUidArray as $newId => $uid) {
                    $key = str_replace($newId, (string)$uid, $key);
                }
            }
            if (\is_array($value)) {
                $value = $this->replaceNewUids($value, $recordUidArray);
            } elseif (strpos($value, 'NEW') !== false) {
                foreach ($recordUidArray as $newId => $uid) {
                    $value = str_replace($newId, (string)$uid, $value);
                }
            }
            $newSetup[$key] = $value;
        }
        return $newSetup;
    }

    protected function getQueryBuilderForTable(string $table) : QueryBuilder
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);
    }
}
