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
use TYPO3\CMS\Core\Site\Entity\Site;
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

    public function createBlogSetup(array $data = []): string
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
        $siteConfiguration = array_merge_recursive($siteConfiguration, $basicSiteConfiguration);
        $siteConfiguration['base'] = $this->determineSiteBase($site, $title);
        $siteIdentifier = $this->useReadableSiteIdentifier($site, $title);
        $this->siteWriter->write($siteIdentifier, $siteConfiguration);
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

        return $siteConfiguration['base'];
    }

    /**
     * The core creates the site for a new root page on its own entry point, since it
     * cannot know the URL. Take the root path where no other site holds it, otherwise
     * an entry point named after the blog, below the site that does.
     */
    protected function determineSiteBase(Site $site, ?string $title): string
    {
        $rootSite = null;
        foreach ($this->siteFinder->getAllSites() as $existingSite) {
            if ($existingSite->getIdentifier() === $site->getIdentifier()) {
                continue;
            }
            if (trim($existingSite->getBase()->getPath(), '/') === '') {
                $rootSite = $existingSite;
                break;
            }
        }

        if ($rootSite === null) {
            return '/';
        }

        // Carrying the host over matters: during site matching a base without one
        // loses against a base that has it, whatever its path.
        $base = rtrim((string)$rootSite->getBase(), '/') . '/' . $this->sanitizeForUse($title);
        foreach ($this->siteFinder->getAllSites() as $existingSite) {
            if ($existingSite->getIdentifier() !== $site->getIdentifier()
                && rtrim((string)$existingSite->getBase(), '/') === $base
            ) {
                return (string)$site->getBase();
            }
        }

        return $base;
    }

    /**
     * Replaces the autogenerated identifier with one named after the blog, where free.
     */
    protected function useReadableSiteIdentifier(Site $site, ?string $title): string
    {
        $currentIdentifier = $site->getIdentifier();
        $identifier = $this->sanitizeForUse($title);
        if ($identifier === '' || $identifier === $currentIdentifier) {
            return $currentIdentifier;
        }
        foreach ($this->siteFinder->getAllSites() as $existingSite) {
            if ($existingSite->getIdentifier() === $identifier) {
                return $currentIdentifier;
            }
        }

        $this->siteWriter->rename($currentIdentifier, $identifier);

        return $identifier;
    }

    protected function sanitizeForUse(?string $title): string
    {
        return trim(strtolower((string)preg_replace('/[^A-Za-z0-9]+/', '-', $title ?? 'blog')), '-');
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
