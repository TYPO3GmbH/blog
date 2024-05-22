<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Repository;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CategoryRepository extends Repository
{
    protected array $settings = [];

    public function initializeObject(): void
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $this->settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'blog');

        $querySettings = GeneralUtility::makeInstance(
            Typo3QuerySettings::class,
            GeneralUtility::makeInstance(Context::class),
            $configurationManager
        );
        $querySettings->setStoragePageIds(GeneralUtility::intExplode(',', (string)$this->settings['persistence']['storagePid']));
        $this->setDefaultQuerySettings($querySettings);

        $this->defaultOrderings = [
            'title' => QueryInterface::ORDER_ASCENDING,
        ];
    }

    public function findByUids(array $uids): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching($query->in('uid', $uids));

        return $query->execute();
    }

    public function getByReference(string $table, int $uid, string $field = 'categories'): ?QueryResultInterface
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
        $categories = array_column($queryBuilder->executeQuery()->fetchAllAssociative(), 'uid_local');

        if (count($categories) > 0) {
            $query = $this->createQuery();
            $querySettings = $query->getQuerySettings();
            $querySettings->setRespectStoragePage(false);
            $querySettings->setRespectSysLanguage(false);

            $conditions = [];
            $conditions[] = $query->in('uid', $categories);

            return $query->matching(
                $query->logicalAnd(...$conditions)
            )->execute();
        }

        return null;
    }
}
