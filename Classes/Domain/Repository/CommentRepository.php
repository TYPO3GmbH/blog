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
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
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
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * @var array
     */
    protected $settings;

    /**
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function initializeObject()
    {
        $this->configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
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
     */
    public function findAllByPost(Post $post)
    {
        $respectPostLanguageId = isset($this->settings['comments']['respectPostLanguageId'])
            ? (int)$this->settings['comments']['respectPostLanguageId']
            : 0;
        $query = $this->createQuery();
        $constraints = [];
        $constraints[] = $query->equals('post', $post->getUid());
        if ($respectPostLanguageId) {
            $constraints[] = $query->logicalOr([
                $query->equals('postLanguageId', $GLOBALS['TSFE']->sys_language_uid),
                $query->equals('postLanguageId', -1)
            ]);
        }
        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param int $limit
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findLatest($limit = 5)
    {
        $query = $this->createQuery();
        $query->setLimit($limit);

        return $query->execute();
    }
}
