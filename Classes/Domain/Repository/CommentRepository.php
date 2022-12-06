<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Repository;

use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CommentRepository extends Repository
{
    protected ConfigurationManagerInterface $configurationManager;
    protected array $settings = [];

    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function initializeObject(): void
    {
        $this->settings = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');

        $querySettings = GeneralUtility::makeInstance(
            Typo3QuerySettings::class,
            GeneralUtility::makeInstance(Context::class),
            $this->configurationManager
        );
        // don't add the pid constraint
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);

        $this->defaultOrderings = [
            'crdate' => QueryInterface::ORDER_DESCENDING,
        ];
    }

    /**
     * @param Post $post
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByPost(Post $post)
    {
        $query = $this->createQuery();
        $constraints = [];
        $constraints[] = $query->equals('post', $post->getUid());
        $constraints = $this->fillConstraintsBySettings($query, $constraints);
        return $query->matching($query->logicalAnd(...$constraints))->execute();
    }

    /**
     * @param string $filter
     * @param int $blogSetup
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByFilter(string $filter = null, int $blogSetup = null)
    {
        $query = $this->createQuery();
        $querySettings = $query->getQuerySettings();
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
            case null:
                // null means all, and all means all but not deleted
                $constraints[] = $query->logicalNot($query->equals('status', Comment::STATUS_DELETED));
                break;
            default:
        }
        if ($blogSetup !== null) {
            $constraints[] = $query->in('pid', $this->getPostPidsByRootPid($blogSetup));
        }
        if (!empty($constraints)) {
            return $query->matching($query->logicalAnd(...$constraints))->execute();
        }

        return $this->findAll();
    }

    /**
     * @param int $limit
     * @param int $blogSetup
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findActiveComments(int $limit = null, int $blogSetup = null)
    {
        $query = $this->createQuery();

        $constraints = [];
        $constraints = $this->fillConstraintsBySettings($query, $constraints);

        if ($limit !== null) {
            $query->setLimit($limit);
        }
        if ($blogSetup !== null) {
            $storagePids = $this->getPostPidsByRootPid($blogSetup);
            if (!empty($storagePids)) {
                $constraints[] = $query->in('pid', $storagePids);
            }
        }
        return $query->matching($query->logicalAnd(...$constraints))->execute();
    }

    /**
     * @param int $blogRootPid
     * @return array
     */
    protected function getPostPidsByRootPid(int $blogRootPid): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');
        $rows = $queryBuilder
            ->select('uid')
            ->from('pages')
            ->where($queryBuilder->expr()->eq('doktype', Constants::DOKTYPE_BLOG_POST))
            ->andWhere($queryBuilder->expr()->eq('pid', $blogRootPid))
            ->execute()
            ->fetchAllAssociative();
        $result = [];
        foreach ($rows as $row) {
            $result[] = $row['uid'];
        }

        return $result;
    }

    /**
     * @param QueryInterface $query
     * @param array $constraints
     * @return array
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function fillConstraintsBySettings(QueryInterface $query, array $constraints): array
    {
        $respectCommentsModeration = isset($this->settings['comments']['moderation'])
            ? (int)$this->settings['comments']['moderation']
            : 0;
        if ($respectCommentsModeration >= 1) {
            $constraints[] = $query->equals('status', Comment::STATUS_APPROVED);
        } else {
            $constraints[] = $query->lessThan('status', Comment::STATUS_DECLINED);
        }

        $respectPostLanguageId = isset($this->settings['comments']['respectPostLanguageId'])
            ? (int)$this->settings['comments']['respectPostLanguageId']
            : 0;
        if ($respectPostLanguageId) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $constraints[] = $query->logicalOr(
                $query->equals('postLanguageId', GeneralUtility::makeInstance(Context::class)->getAspect('language')->getId()),
                $query->equals('postLanguageId', -1),
            );
        }

        $tstamp = time();
        $constraints[] = $query->logicalAnd(
            $query->logicalOr(
                $query->equals('post.starttime', 0),
                $query->lessThanOrEqual('post.starttime', $tstamp)
            ),
            $query->logicalOr(
                $query->equals('post.endtime', 0),
                $query->greaterThanOrEqual('post.endtime', $tstamp)
            )
        );
        $constraints[] = $query->logicalAnd(
            $query->equals('post.hidden', 0),
            $query->equals('post.deleted', 0)
        );
        return $constraints;
    }
}
