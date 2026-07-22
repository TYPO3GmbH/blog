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
use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;

class SetupService
{
    public function __construct(
        private readonly SiteFinder $siteFinder,
        private readonly SiteWriter $siteWriter
    ) {
    }

    public function determineBlogSetups(): array
    {
        $setups = [];
        $queryBuilder = $this->getQueryBuilderForTable('pages');
        $blogRootPages = $queryBuilder
            ->select('uid', 'title')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('doktype', $queryBuilder->createNamedParameter(PageRepository::DOKTYPE_SYSFOLDER, Connection::PARAM_INT)),
                $queryBuilder->expr()->eq('module', $queryBuilder->createNamedParameter('blog', Connection::PARAM_STR)),
                $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)),
            )
            ->groupBy('uid')
            ->executeQuery()
            ->fetchAllAssociative();

        foreach ($blogRootPages as $blogRootPage) {
            $blogUid = (int) $blogRootPage['uid'];
            $blogTitle = (string) $blogRootPage['title'];
            if (!array_key_exists($blogUid, $setups)) {
                $rootline = array_reverse(GeneralUtility::makeInstance(RootlineUtility::class, $blogUid)->get());

                $queryBuilder = $this->getQueryBuilderForTable('pages');
                $articleCount = $queryBuilder
                    ->count('*')
                    ->from('pages')
                    ->where(
                        $queryBuilder->expr()->eq('doktype', $queryBuilder->createNamedParameter(Constants::DOKTYPE_BLOG_POST, Connection::PARAM_INT)),
                        $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($blogUid, Connection::PARAM_INT)),
                        $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)),
                    )
                    ->executeQuery()
                    ->fetchOne();

                $setups[$blogUid] = [
                    'uid' => $blogUid,
                    'title' => $blogTitle,
                    'path' => implode(' / ', array_map(function ($page) {
                        return $page['title'];
                    }, $rootline)),
                    'rootline' => $rootline,
                    'articleCount' => (int) $articleCount,
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

        // Site Modifications
        $site = $this->siteFinder->getSiteByRootPageId($blogRootUid);
        $siteIdentifier = $site->getIdentifier();
        $siteConfiguration = $site->getConfiguration();
        $basicSiteConfiguration = [
            'imports' => [
                [
                    'resource' => 'EXT:blog/Configuration/Routes/Default.yaml'
                ]
            ],
            'dependencies' => [
                'blog/standalone',
            ]
        ];
        $this->siteWriter->write(
            $siteIdentifier,
            array_merge_recursive($siteConfiguration, $basicSiteConfiguration)
        );
        $this->siteWriter->writeSettings(
            $siteIdentifier,
            [
                'plugin' => [
                    'tx_blog' => [
                        'settings' => [
                            'blogUid' => (int) $recordUidArray['NEW_blogRoot'],
                            'categoryUid' => (int) $recordUidArray['NEW_blogCategoryPage'],
                            'tagUid' => (int) $recordUidArray['NEW_blogTagPage'],
                            'authorUid' => (int) $recordUidArray['NEW_blogAuthorPage'],
                            'archiveUid' => (int) $recordUidArray['NEW_blogArchivePage'],
                            'storagePid' => (int) $recordUidArray['NEW_blogFolder'],
                        ]
                    ]
                ]
            ]
        );

        // Relations
        $blogSetupRelations = require GeneralUtility::getFileAbsFileName('EXT:blog/Configuration/DataHandler/BlogSetupRelations.php');
        $blogSetupRelations = $this->replaceNewUids($blogSetupRelations, $recordUidArray);
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->start($blogSetupRelations, []);
        $dataHandler->process_datamap();
        $recordUidArray = array_merge_recursive($recordUidArray, $dataHandler->substNEWwithIDs);

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
