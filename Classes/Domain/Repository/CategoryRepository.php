<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CategoryRepository extends Repository
{
    /**
     * Initializes the repository.
     *
     * @throws \InvalidArgumentException
     */
    public function initializeObject(): void
    {
        // @TODO: It looks like extbase ignore storage settings for sys_category.
        // @TODO: this hack set the storage handling for sys_category table.
        $configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(true);
        $querySettings->setStoragePageIds(GeneralUtility::trimExplode(',', $settings['storagePid']));

        $this->setDefaultQuerySettings($querySettings);
        $this->defaultOrderings = [
            'title' => QueryInterface::ORDER_ASCENDING,
        ];
    }

    /**
     * @param string $table
     * @param int $uid
     * @param string $field
     * @return array|null|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getByReference($table, $uid, $field = 'categories')
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);

        $queryBuilder = $connectionPool->getConnectionForTable('sys_category_record_mm')->createQueryBuilder();
        $queryBuilder
            ->select('uid_local')
            ->from('sys_category_record_mm')
            ->where(
                $queryBuilder->expr()->eq('tablenames', $queryBuilder->createNamedParameter($table)),
                $queryBuilder->expr()->eq('fieldname', $queryBuilder->createNamedParameter($field)),
                $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($uid))
            );
        $categories = array_column($queryBuilder->execute()->fetchAll(), 'uid_local');

        if (!empty($categories)) {
            $query = $this->createQuery();
            $querySettings = $query->getQuerySettings();
            $querySettings->setRespectStoragePage(false);
            $querySettings->setRespectSysLanguage(false);

            $conditions = [];
            $conditions[] = $query->in('uid', $categories);

            return $query->matching(
                $query->logicalAnd(
                    $conditions
                )
            )->execute();
        }

        return null;
    }
}
