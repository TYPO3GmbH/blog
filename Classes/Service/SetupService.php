<?php

namespace T3G\AgencyPack\Blog\Service;

use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Install\ExtensionInstaller;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class SetupService.
 */
class SetupService
{
    /**
     * @var array of created record uids
     */
    protected $recordUidArray = [];

    /**
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    public function determineBlogSetups()
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
                $setups[$blogUid] = [
                    'uid' => $blogUid,
                    'title' => $title,
                    'articleCount' => $blogRootPage['cnt'],
                ];
            }
        }

        return $setups;
    }

    /**
     * @param $uid
     *
     * @return array
     */
    public function getBlogRecordAsArray($uid)
    {
        $queryBuilder = $this->getQueryBuilderForTable('pages');
        return $queryBuilder
            ->select('*')
            ->from('pages')
            ->where($queryBuilder->expr()->eq('uid', $uid))
            ->execute()
            ->fetch();
    }

    /**
     * @param array $data
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function createBlogSetup(array $data)
    {
        $useTemplate = array_key_exists('template', $data) ? (bool) $data['template'] : false;
        $installExtension = array_key_exists('install', $data) ? (bool) $data['install'] : false;
        $title = array_key_exists('title', $data) ? (string) $data['title'] : null;

        if ($installExtension
            && $this->installExtension('rx_shariff')
            && $this->installExtension('blog_template')
        ) {
            $useTemplate = true;
        }

        $blogSetup = $useTemplate
            ? GeneralUtility::getFileAbsFileName('EXT:blog/Configuration/DataHandler/BlogSetupRecordsWithTemplate.php')
            : GeneralUtility::getFileAbsFileName('EXT:blog/Configuration/DataHandler/BlogSetupRecords.php');

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
                $blogRootUid = (int) $this->recordUidArray['NEW_blogRoot'];
                $blogFolderUid = (int) $this->recordUidArray['NEW_blogFolder'];
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
                $sysTemplateUid = (int) $this->recordUidArray['NEW_SysTemplate'];
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
                        array_values($this->recordUidArray),
                        $record['constants']
                    ))
                    ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($sysTemplateUid, \PDO::PARAM_INT)))
                    ->execute();
            }
        }

        BackendUtility::setUpdateSignal('updatePageTree');
        return $result;
    }

    /**
     * @param array $setup
     *
     * @return array
     */
    protected function replaceNewUids(array $setup)
    {
        $newSetup = [];
        foreach ($setup as $key => &$value) {
            if (false !== strpos($key, 'NEW')) {
                foreach ($this->recordUidArray as $newId => $uid) {
                    $key = str_replace($newId, $uid, $key);
                }
            }
            if (is_array($value)) {
                /* @noinspection ReferenceMismatchInspection */
                $value = $this->replaceNewUids($value);
            } else {
                if (false !== strpos($value, 'NEW')) {
                    foreach ($this->recordUidArray as $newId => $uid) {
                        /* @noinspection ReferenceMismatchInspection */
                        $value = str_replace($newId, $uid, $value);
                    }
                }
            }
            /* @noinspection ReferenceMismatchInspection */
            $newSetup[$key] = $value;
        }

        return $newSetup;
    }

    /**
     * @param string $extKey
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    protected function installExtension($extKey)
    {
        $installer = GeneralUtility::makeInstance(ExtensionInstaller::class, $extKey);
        $databaseQueries = [];
        $customMessages = '';

        return $installer->performUpdate($databaseQueries, $customMessages);
    }

    /**
     * @param string $table
     *
     * @return QueryBuilder
     */
    protected function getQueryBuilderForTable(string $table) : QueryBuilder
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);
    }

    /**
     * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }
}
