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
use TYPO3\CMS\Core\Database\DatabaseConnection;
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
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \InvalidArgumentException
     */
    public function initializeObject()
    {
        $this->defaultOrderings = [
            'title' => QueryInterface::ORDER_ASCENDING,
        ];
    }

    /**
     * @param int $limit
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findTopByUsage($limit = 20)
    {
        $sql = [];
        $sql[] = 'SELECT tx_blog_domain_model_tag.uid, tx_blog_domain_model_tag.title, COUNT(tx_blog_tag_pages_mm.uid_foreign) as cnt';
        $sql[] = 'FROM tx_blog_domain_model_tag';
        $sql[] = 'JOIN tx_blog_tag_pages_mm ON tx_blog_tag_pages_mm.uid_foreign = tx_blog_domain_model_tag.uid';
        $sql[] = 'GROUP BY tx_blog_domain_model_tag.title';
        $sql[] = 'ORDER BY cnt DESC';
        $sql[] = 'LIMIT ' . (int)$limit;

        $sql = implode(' ', $sql);
        $result = $this->getDatabaseConnection()->sql_query($sql);
        $rows = [];
        while ($row = $this->getDatabaseConnection()->sql_fetch_assoc($result)) {
            /** @var array $row */
            $row['tagObject'] = $this->findByUid($row['uid']);
            $rows[] = $row;
        }
        // shuffle tags, ordering is only to get the top used tags
        shuffle($rows);
        return $rows;
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
