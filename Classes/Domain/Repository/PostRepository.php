<?php

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
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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
     * @throws \Exception
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
        return $this->getFindAllQuery()->execute();
    }

    /**
     * @param int $blogSetup
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllByPid($blogSetup)
    {
        $query = $this->getFindAllQuery();

        if (null !== $blogSetup) {
            $existingConstraint = $query->getConstraint();
            $additionalConstraint = $query->equals('pid', $blogSetup);
            $query->matching($query->logicalAnd([
                $existingConstraint,
                $additionalConstraint
            ]));
        }

        return $query->execute();
    }

    /**
     * @param int $limit
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllWithLimit($limit)
    {
        $query = $this->getFindAllQuery();

        if (null !== $limit) {
            $query->setLimit(intval($limit));
        }

        return $query->execute();
    }

    /**
     * @return QueryInterface
     */
    protected function getFindAllQuery()
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }
        $constraints[] = $query->logicalOr([
            $query->equals('archiveDate', 0),
            $query->greaterThanOrEqual('archiveDate', time()),
        ]);
        $query->matching($query->logicalAnd($constraints));

        return $query;
    }

    /**
     * @param Author $author
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByAuthor(Author $author)
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }
        $constraints[] = $query->contains('authors', $author);

        return $query->matching($query->logicalAnd($constraints))->execute();
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
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }

        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param Tag $tag
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByTag(Tag $tag)
    {
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $constraints[] = $query->contains('tags', $tag);
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }

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
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }

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
        $pageId = !empty($GLOBALS['TSFE'])
            ? (int) $GLOBALS['TSFE']->id
            : (int) GeneralUtility::_GP('id');
        $query = $this->createQuery();
        $constraints = $this->defaultConstraints;
        $storagePidConstraint = $this->getStoragePidConstraint();
        if ($storagePidConstraint instanceof ComparisonInterface) {
            $constraints[] = $storagePidConstraint;
        }
        $constraints[] = $query->equals('uid', $pageId);

        /** @var Post $post */
        $post = $query->matching($query->logicalAnd($constraints))->execute()->getFirst();

        return $post;
    }

    /**
     * Get month and years with posts.
     *
     * @throws \InvalidArgumentException
     */
    public function findMonthsAndYearsWithPosts()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');

        $conditions = $queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq(
                'doktype',
                $queryBuilder->createNamedParameter(Constants::DOKTYPE_BLOG_POST, \PDO::PARAM_INT)
            ),
            $queryBuilder->expr()->in(
                'pid',
                $this->getPidsForConstraints()
            )
        );

        return $queryBuilder
            ->select(
                'crdate_month AS month',
                'crdate_year AS year'
            )
            ->addSelectLiteral($queryBuilder->expr()->count('*', 'count'))
            ->from('pages')
            ->where($conditions)
            ->groupBy(
                'month',
                'year'
            )
            ->orderBy('year', 'DESC')
            ->addOrderBy('month', 'DESC')
            ->execute()
            ->fetchAll();
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFontendController()
    {
        return $GLOBALS['TSFE'];
    }

    /**
     * @return array
     */
    protected function getStoragePidsFromTypoScript()
    {
        $configurationManager = $this->objectManager->get(ConfigurationManager::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        return GeneralUtility::intExplode(',', $settings['persistence']['storagePid']);
    }

    /**
     * @return ComparisonInterface
     */
    protected function getStoragePidConstraint()
    {
        if (TYPO3_MODE === 'FE') {
            $pids = $this->getPidsForConstraints();

            $query = $this->createQuery();

            return $query->in('pid', $pids);
        }
    }

    /**
     * @return array
     */
    protected function getPidsForConstraints()
    {
        // only add non empty pids (pid 0 will be removed as well
        $pids = array_filter($this->getStoragePidsFromTypoScript(), function ($v) {
            return !empty($v);
        });

        if (count($pids) === 0) {
            $rootLine = $this->getTypoScriptFontendController()->sys_page
                ->getRootLine($this->getTypoScriptFontendController()->id);
            foreach ($rootLine as $value) {
                $pids[] = $value['uid'];
            }
        }

        return $pids;
    }
}
