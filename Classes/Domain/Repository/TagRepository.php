<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class TagRepository extends Repository
{
    protected array $settings = [];

    public function initializeObject(): void
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $this->settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'blog');

        $this->defaultOrderings = [
            'title' => QueryInterface::ORDER_ASCENDING,
        ];
    }

    public function findByUids(array $uids): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr([
                $query->in('uid', $uids),
                $query->in('l18n_parent', $uids)
            ])
        );

        return $query->execute();
    }

    public function findTopByUsage(int $limit = 20): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_blog_domain_model_tag');
        $queryBuilder
            ->select('t.uid', 't.title')
            ->addSelectLiteral($queryBuilder->expr()->count('mm.uid_foreign', 'cnt'))
            ->from('tx_blog_domain_model_tag', 't')
            ->join('t', 'tx_blog_tag_pages_mm', 'mm', 'mm.uid_foreign = t.uid')
            ->groupBy('t.title', 't.uid')
            ->orderBy('cnt', 'DESC')
            ->setMaxResults($limit);

        // limitation to storage pid for multi domain purpose
        if ($this->settings['persistence']['storagePid']) {
            // force storage pids as integer
            $storagePids = GeneralUtility::intExplode(',', $this->settings['persistence']['storagePid']);
            $queryBuilder->where('t.pid IN(' . implode(',', $storagePids) . ')');
        }

        $result = $queryBuilder
            ->executeQuery()
            ->fetchAllAssociative();

        $rows = [];
        foreach ($result as $row) {
            $row['tagObject'] = $this->findByUid($row['uid']);
            $rows[] = $row;
        }

        // Shuffle tags, ordering is only to get the top used tags
        shuffle($rows);
        return $rows;
    }
}
