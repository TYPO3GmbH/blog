<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates;

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

final class CategoryTypeUpdate extends AbstractUpdate implements UpgradeWizardInterface
{
    protected string $title = 'EXT:blog: Use Blog-Type for Categories';
    protected string $table = 'sys_category';

    public function updateNecessary(): bool
    {
        $records = $this->getAffectedRecords();
        return (bool) count($records);
    }

    /**
     * @return bool
     */
    public function executeUpdate(): bool
    {
        $records = $this->getAffectedRecords();
        foreach ($records as $record) {
            $this->updateRecord($this->table, (int) $record['uid'], [
                'record_type' => Constants::CATEGORY_TYPE_BLOG
            ]);
        }

        return true;
    }

    private function getAffectedRecords(): array
    {
        $pages = array_map(
            function ($page) {
                return $page['uid'];
            },
            $this->getBlogStorageFolders()
        );

        $queryBuilder = $this->createQueryBuilder($this->table);
        $criteria = [
            $this->createEqualIntCriteria($queryBuilder, 'record_type', Constants::CATEGORY_TYPE_DEFAULT),
            $this->createInCriteria($queryBuilder, 'pid', $pages)
        ];
        $records = $this->getRecordsByCriteria($queryBuilder, $this->table, $criteria);

        return $records;
    }
}
