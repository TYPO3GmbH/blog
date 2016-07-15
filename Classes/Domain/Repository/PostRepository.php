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
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class PostRepository.
 */
class PostRepository extends Repository
{
    /**
     * @var array
     */
    protected $defaultConstraints = [];

    /**
     *
     */
    public function initializeObject()
    {
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        // don't add the pid constraint
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);

        $query = $this->createQuery();
        $this->defaultConstraints[] = $query->equals('doktype', Constants::DOKTYPE_BLOG_POST);

        $this->defaultOrderings = [
            'crdate' => QueryInterface::ORDER_DESCENDING,
        ];
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAll()
    {
        $query = $this->createQuery();

        return $query->matching($query->logicalAnd($this->defaultConstraints))->execute();
    }

    /**
     * @param Category $category
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByCategory(Category $category)
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $constraints[] = $query->contains('categories', $category);

        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param int $year
     * @param int $month
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByMonthAndYear($year, $month = null)
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;

        if ($month !== null) {
            $startDate = mktime(0, 0, 0, $month, 1, $year);
            $endDate = mktime(23, 59, 59, $month, date('t', $startDate), $year);
        } else {
            $startDate = mktime(0, 0, 0, 1, 1, $year);
            $endDate = mktime(23, 59, 59, 12, 31, $year);
        }
        $constraints[] = $query->greaterThanOrEqual('crdate', $startDate);
        $constraints[] = $query->lessThanOrEqual('crdate', $endDate);

        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @return Post
     */
    public function findCurrentPost()
    {
        $pageId = (int) GeneralUtility::_GP('id');
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $constraints[] = $query->equals('uid', $pageId);

        /** @var Post $post */
        $post = $query->matching($query->logicalAnd($constraints))->execute()->getFirst();

        return $post;
    }

    /**
     * Get month and years with posts.
     */
    public function findMonthsAndYearsWithPosts()
    {
        $sql = array();
        $sql[] = 'SELECT MONTH(FROM_UNIXTIME(crdate)) as month, YEAR(FROM_UNIXTIME(crdate)) as year, count(*) as count';
        $sql[] = 'FROM pages';
        $sql[] = 'WHERE doktype = ' . Constants::DOKTYPE_BLOG_POST;
        $sql[] = '  AND hidden = 0 AND deleted = 0';
        $sql[] = 'GROUP BY';
        $sql[] = '  MONTH(FROM_UNIXTIME(crdate)),';
        $sql[] = '  YEAR(FROM_UNIXTIME(crdate))';
        $sql[] = 'ORDER BY';
        $sql[] = '  YEAR(FROM_UNIXTIME(crdate)) DESC,';
        $sql[] = '  MONTH(FROM_UNIXTIME(crdate)) DESC';

        $sql = implode(' ', $sql);
        $result = $this->getDatabaseConnection()->sql_query($sql);
        $rows = array();
        while ($row = $this->getDatabaseConnection()->sql_fetch_assoc($result)) {
            $rows[] = $row;
        }

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
