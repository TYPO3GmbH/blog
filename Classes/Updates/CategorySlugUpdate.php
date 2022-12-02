<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * CategorySlugUpdate
 */
class CategorySlugUpdate implements UpgradeWizardInterface
{
    /**
     * @var string
     */
    protected $table = 'sys_category';

    /**
     * @var string
     */
    protected $slugField = 'slug';

    /**
    * @return string
    */
    public function getIdentifier(): string
    {
        return self::class;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return '[EXT:blog] Generate Path-Segments for Categories';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }

    /**
     * @return bool
     */
    public function updateNecessary(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->table);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $elementCount = $queryBuilder
            ->count('uid')
            ->from($this->table)
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq($this->slugField, $queryBuilder->createNamedParameter('')),
                    $queryBuilder->expr()->isNull($this->slugField)
                )
            )
            ->execute()->fetchOne();

        return (bool)$elementCount;
    }

    /**
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($this->table);
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $statement = $queryBuilder
            ->select('*')
            ->from($this->table)
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq($this->slugField, $queryBuilder->createNamedParameter('')),
                    $queryBuilder->expr()->isNull($this->slugField)
                )
            )
            ->addOrderBy('t3ver_wsid', 'asc')
            ->addOrderBy('pid', 'asc')
            ->addOrderBy('sorting', 'asc')
            ->execute();

        $fieldConfig = $GLOBALS['TCA'][$this->table]['columns'][$this->slugField]['config'];
        $evalInfo = !empty($fieldConfig['eval']) ? GeneralUtility::trimExplode(',', $fieldConfig['eval'], true) : [];
        $hasToBeUniqueInSite = in_array('uniqueInSite', $evalInfo, true);
        $hasToBeUniqueInPid = in_array('uniqueInPid', $evalInfo, true);
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, $this->table, $this->slugField, $fieldConfig);

        while ($record = $statement->fetch()) {
            $recordId = (int)$record['uid'];
            $pid = (int)$record['pid'];

            // Respect Workspace
            if ($pid === -1) {
                $queryBuilder = $connection->createQueryBuilder();
                $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
                $liveVersion = $queryBuilder
                    ->select('pid')
                    ->from($this->table)
                    ->where(
                        $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($record['t3ver_oid'], \PDO::PARAM_INT))
                    )->execute()->fetch();
                $pid = (int)$liveVersion['pid'];
            }

            // Build Slug
            $slug = $slugHelper->generate($record, $pid);
            $state = RecordStateFactory::forName($this->table)->fromArray($record, $pid, $recordId);
            if ($hasToBeUniqueInSite && !$slugHelper->isUniqueInSite($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
            }
            if ($hasToBeUniqueInPid && !$slugHelper->isUniqueInPid($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
            }

            // Update Record
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder
                ->update($this->table)
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                    )
                )
                ->set('slug', $slug);
            $queryBuilder->execute();
        }

        return true;
    }
}
