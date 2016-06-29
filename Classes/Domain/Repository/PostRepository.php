<?php
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
use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PostRepository
 */
class PostRepository
{

    /**
     * @var string name of the database table
     */
    protected $table = 'pages';

    /**
     * Find all blog posts
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function findAll($limit = 10, $offset = 0)
    {
        $queryBuilder = $this->getQueryBuilder($this->table);
        return $queryBuilder
            ->select(['*'])
            ->from($this->table)
            ->where(
                $queryBuilder->expr()->eq('doktype', Constants::DOKTYPE_BLOG_POST)
            )
            ->orderBy('pages.crdate', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->execute()
            ->fetchAll();
    }

    /**
     * @param string $table
     *
     * @return \TYPO3\CMS\Core\Database\Connection
     */
    protected function getDatabaseConnection($table)
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($table);
    }

    /**
     * @param string $table
     *
     * @return \TYPO3\CMS\Core\Database\Query\QueryBuilder
     */
    protected function getQueryBuilder($table)
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
    }
}
