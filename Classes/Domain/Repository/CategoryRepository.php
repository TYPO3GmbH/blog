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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class CategoryRepository
 */
class CategoryRepository extends Repository
{
    /**
     * Initializes the repository.
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \InvalidArgumentException
     */
    public function initializeObject()
    {
        // @TODO: It looks like extbase ignore storage settings for sys_category.
        // @TODO: this hack set the storage handling for sys_category table.
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $settings =  $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(true);
        $querySettings->setStoragePageIds(GeneralUtility::trimExplode(',', $settings['storagePid']));

        $this->setDefaultQuerySettings($querySettings);
        $this->defaultOrderings = array(
            'title' => QueryInterface::ORDER_ASCENDING,
        );
    }
}
