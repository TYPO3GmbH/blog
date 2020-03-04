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
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;

class SetupService
{
    /**
     * @var array of created record uids
     */
    protected $recordUidArray = [];

    public function determineBlogSetups(): array
    {
        $setups = [];
        $queryBuilder = $this->getQueryBuilderForTable('pages');
        $blogRootPages = $queryBuilder
            ->select('pid')
            ->addSelectLiteral($queryBuilder->expr()->count('pid', 'cnt'))
            ->from('pages')
            ->where($queryBuilder->expr()->eq('doktype', $queryBuilder->createNamedParameter(Constants::DOKTYPE_BLOG_POST, \PDO::PARAM_INT)))
            ->groupBy('pid')
            ->execute()
            ->fetchAll();
        foreach ($blogRootPages as $blogRootPage) {
            $blogUid = $blogRootPage['pid'];
            if (!array_key_exists($blogUid, $setups)) {
                $queryBuilder = $this->getQueryBuilderForTable('pages');
                $title = $queryBuilder
                    ->select('title')
                    ->from('pages')
                    ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($blogUid, \PDO::PARAM_INT)))
                    ->execute()
                    ->fetchColumn();
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

    public function createBlogSetup(array $data): bool
    {
        $title = array_key_exists('title', $data) ? (string)$data['title'] : null;
        $blogSetup = GeneralUtility::getFileAbsFileName('EXT:blog/Configuration/DataHandler/BlogSetupRecords.php');

        $result = false;
        if (file_exists($blogSetup)) {
            /* @noinspection PhpIncludeInspection */
            $blogSetup = require $blogSetup;
            if ($title !== null) {
                $blogSetup['pages']['NEW_blogRoot']['title'] = $title;
            }
            $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
            $dataHandler->start($blogSetup, []);
            $result = $dataHandler->process_datamap();
            $this->recordUidArray = array_merge_recursive($this->recordUidArray, $dataHandler->substNEWwithIDs);
            if ($result !== false) {
                $result = true;
                // Update page id in PageTSConfig
                $blogRootUid = (int)$this->recordUidArray['NEW_blogRoot'];
                $blogFolderUid = (int)$this->recordUidArray['NEW_blogFolder'];
                $queryBuilder = $this->getQueryBuilderForTable('pages');
                $queryBuilder->getRestrictions()->removeAll();
                $record = $queryBuilder
                    ->select('TSconfig')
                    ->from('pages')
                    ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($blogRootUid, \PDO::PARAM_INT)))
                    ->execute()
                    ->fetch();
                $queryBuilder->update('pages')
                    ->set('TSconfig', str_replace('NEW_blogFolder', $blogFolderUid, $record['TSconfig']))
                    ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($blogRootUid, \PDO::PARAM_INT)))
                    ->execute();

                $blogSetupRelations = GeneralUtility::getFileAbsFileName('EXT:blog/Configuration/DataHandler/BlogSetupRelations.php');
                if (file_exists($blogSetupRelations)) {
                    /* @noinspection PhpIncludeInspection */
                    $blogSetupRelations = require $blogSetupRelations;
                    $blogSetupRelations = $this->replaceNewUids($blogSetupRelations);
                    $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
                    $dataHandler->start($blogSetupRelations, []);
                    $resultRelations = $dataHandler->process_datamap();
                    $this->recordUidArray = array_merge_recursive($this->recordUidArray, $dataHandler->substNEWwithIDs);
                    if ($resultRelations !== false) {
                        $result = true;
                    }
                }
            }
            if ($result === true) {
                // Replace UIDs in constants
                $sysTemplateUid = (int)$this->recordUidArray['NEW_SysTemplate'];
                $queryBuilder = $this->getQueryBuilderForTable('sys_template');
                $record = $queryBuilder
                    ->select('constants')
                    ->from('sys_template')
                    ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($sysTemplateUid, \PDO::PARAM_INT)))
                    ->execute()
                    ->fetch();
                $queryBuilder
                    ->update('sys_template')
                    ->set('constants', str_replace(
                        array_keys($this->recordUidArray),
                        $this->recordUidArray,
                        $record['constants']
                    ))
                    ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($sysTemplateUid, \PDO::PARAM_INT)))
                    ->execute();
            }
        }

        BackendUtility::setUpdateSignal('updatePageTree');
        return $result;
    }

    protected function replaceNewUids(array $setup): array
    {
        $newSetup = [];
        foreach ($setup as $key => &$value) {
            if (strpos($key, 'NEW') !== false) {
                foreach ($this->recordUidArray as $newId => $uid) {
                    $key = str_replace($newId, $uid, $key);
                }
            }
            if (\is_array($value)) {
                $value = $this->replaceNewUids($value);
            } elseif (strpos($value, 'NEW') !== false) {
                foreach ($this->recordUidArray as $newId => $uid) {
                    $value = str_replace($newId, $uid, $value);
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
