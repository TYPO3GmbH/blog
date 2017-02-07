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
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class CommentRepository.
 */
class CommentRepository extends Repository
{
    /**
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function initializeObject()
    {
        $this->configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
        $this->settings = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');

        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        // don't add the pid constraint
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);

        $this->defaultOrderings = [
            'crdate' => QueryInterface::ORDER_DESCENDING,
        ];
    }

    /**
     * @param Post $post
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByPost(Post $post)
    {
        $query = $this->createQuery();
        $constraints = [];
        $constraints[] = $query->equals('post', $post->getUid());
        $constraints = $this->fillConstraintsBySettings($query, $constraints);
        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param int $limit
     * @param int $blogSetup
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @deprecated since 1.3.0 will be removed in 2.0.0
     */
    public function findLatest($limit = 5, $blogSetup = null)
    {
        GeneralUtility::logDeprecatedFunction();
        return $this->findActiveComments($limit, $blogSetup);
    }

    /**
     * @param string $filter
     * @param int    $blogSetup
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByFilter($filter = null, $blogSetup = null)
    {
        $query = $this->createQuery();
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $query->setQuerySettings($querySettings);

        $constraints = [];
        switch ($filter) {
            case 'pending':
                $constraints[] = $query->equals('status', Comment::STATUS_PENDING);
                break;
            case 'approved':
                $constraints[] = $query->equals('status', Comment::STATUS_APPROVED);
                break;
            case 'declined':
                $constraints[] = $query->equals('status', Comment::STATUS_DECLINED);
                break;
            case 'deleted':
                $constraints[] = $query->equals('status', Comment::STATUS_DELETED);
                break;
        }
        if ($blogSetup !== null) {
            $constraints[] = $query->in('pid', $this->getPostPidsByRootPid($blogSetup));
        }
        if (!empty($constraints)) {
            return $query->matching($query->logicalAnd($constraints))->execute();
        }

        return $this->findAll();
    }

    /**
     * @param int    $limit
     * @param int    $blogSetup
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findActiveComments($limit = null, $blogSetup = null)
    {
        $query = $this->createQuery();

        $constraints = [];

        $constraints = $this->fillConstraintsBySettings($query, $constraints);

        if ($limit !== null) {
            $query->setLimit($limit);
        }
        if ($blogSetup !== null) {
            $constraints[] = $query->in('pid', $this->getPostPidsByRootPid($blogSetup));
        }
        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param int $blogRootPid
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function getPostPidsByRootPid($blogRootPid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');
        $rows = $queryBuilder
            ->select('uid')
            ->from('pages')
            ->where($queryBuilder->expr()->eq('doktype', Constants::DOKTYPE_BLOG_POST))
            ->andWhere($queryBuilder->expr()->eq('pid', $blogRootPid))
            ->execute()
            ->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[] = $row['uid'];
        }

        return $result;
    }
    /**
     * @param QueryInterface $query
     * @param array $constraints
     *
     * @return array
     *
     */
    public function fillConstraintsBySettings(QueryInterface $query, array $constraints)
    {
        $respectCommentsModeration = isset($this->settings['comments']['moderation'])
            ? (int) $this->settings['comments']['moderation']
            : 0;
        if ($respectCommentsModeration === 1) {
            $constraints[] = $query->equals('status', Comment::STATUS_APPROVED);
        } else {
            $constraints[] = $query->lessThan('status', Comment::STATUS_DECLINED);
        }

        $respectPostLanguageId = isset($this->settings['comments']['respectPostLanguageId'])
            ? (int) $this->settings['comments']['respectPostLanguageId']
            : 0;
        if ($respectPostLanguageId) {
            $constraints[] = $query->logicalOr([
                $query->equals('postLanguageId', $GLOBALS['TSFE']->sys_language_uid),
                $query->equals('postLanguageId', -1),
            ]);
        }

        $tstamp = time();
        $constraints[] = $query->logicalAnd([
            $query->logicalOr([
                $query->equals('post.starttime', 0),
                $query->greaterThanOrEqual('post.starttime', $tstamp)
            ]),
            $query->logicalOr([
                $query->equals('post.endtime', 0),
                $query->lessThan('post.endtime', $tstamp)
            ])
        ]);
        $constraints[] = $query->logicalAnd([
            $query->equals('post.hidden', 0),
            $query->equals('post.deleted', 0)
        ]);
        return $constraints;
    }
}
