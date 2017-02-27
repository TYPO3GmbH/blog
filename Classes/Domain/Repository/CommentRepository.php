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
use TYPO3\CMS\Core\Database\DatabaseConnection;
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
        $respectPostLanguageId = isset($this->settings['comments']['respectPostLanguageId'])
            ? (int) $this->settings['comments']['respectPostLanguageId']
            : 0;
        $query = $this->createQuery();
        $constraints = [];
        $constraints[] = $query->equals('post', $post->getUid());
        $constraints[] = $query->lessThan('status', Comment::STATUS_DECLINED);
        if ($respectPostLanguageId) {
            $constraints[] = $query->logicalOr([
                $query->equals('postLanguageId', $GLOBALS['TSFE']->sys_language_uid),
                $query->equals('postLanguageId', -1),
            ]);
        }

        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param int $limit
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findLatest($limit = 5)
    {
        $query = $this->createQuery();
        $query->setLimit($limit);
        $constraint = $query->lessThan('status', Comment::STATUS_DECLINED);

        return $query->matching($constraint)->execute();
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
     * @param int $blogRootPid
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function getPostPidsByRootPid($blogRootPid)
    {
        $rows = $this->getDatabaseConnection()->exec_SELECTgetRows(
            'uid',
            'pages',
            'doktype = '.Constants::DOKTYPE_BLOG_POST.' AND pid = '.(int) $blogRootPid
        );
        $result = [];
        foreach ($rows as $row) {
            $result[] = $row['uid'];
        }

        return $result;
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
