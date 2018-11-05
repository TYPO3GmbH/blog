<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Repository;

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
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class TagRepository.
 */
class TagRepository extends Repository
{
    /**
     * Initializes the repository.
     *
     * @throws \InvalidArgumentException
     */
    public function initializeObject(): void
    {
        $this->defaultOrderings = [
            'title' => QueryInterface::ORDER_ASCENDING,
        ];
    }

    /**
     * @param int $limit
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \InvalidArgumentException
     */
    public function findTopByUsage($limit = 20)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_blog_domain_model_tag');
        $result = $queryBuilder
            ->select('t.uid', 't.title')
            ->addSelectLiteral($queryBuilder->expr()->count('mm.uid_foreign', 'cnt'))
            ->from('tx_blog_domain_model_tag', 't')
            ->join('t', 'tx_blog_tag_pages_mm', 'mm', 'mm.uid_foreign = t.uid')
            ->groupBy('t.title', 't.uid')
            ->orderBy('cnt', 'DESC')
            ->setMaxResults($limit)
            ->execute()
            ->fetchAll();

        $rows = [];
        foreach ($result as $row) {
            $row['tagObject'] = $this->findByUid($row['uid']);
            $rows[] = $row;
        }

        // Shuffle tags, ordering is only to get the top used tags
        /** @noinspection NonSecureShuffleUsageInspection */
        shuffle($rows);
        return $rows;
    }
}
