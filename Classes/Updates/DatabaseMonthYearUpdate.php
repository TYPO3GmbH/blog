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

final class DatabaseMonthYearUpdate extends AbstractUpdate implements UpgradeWizardInterface
{
    /**
     * @var string
     */
    protected $title = 'EXT:blog: Set new month and year fields for existing blog posts';

    /**
     * @var string
     */
    protected $table = 'pages';

    public function updateNecessary(): bool
    {
        $records = $this->getAffectedRecords();
        return (bool) count($records);
    }

    public function executeUpdate(): bool
    {
        $records = $this->getAffectedRecords();
        foreach ($records as $record) {
            $timestamp = $record['crdate'] ?? time();
            $this->updateRecord($this->table, (int) $record['uid'], [
                'crdate_month' => date('n', (int)$timestamp),
                'crdate_year' => date('Y', (int)$timestamp)
            ]);
        }
        return true;
    }

    private function getAffectedRecords(): array
    {
        $queryBuilder = $this->createQueryBuilder($this->table);
        $criteria = [
            $this->createEqualIntCriteria($queryBuilder, 'doktype', Constants::DOKTYPE_BLOG_POST),
            $this->createEqualIntCriteria($queryBuilder, 'crdate_month', 0),
            $this->createEqualIntCriteria($queryBuilder, 'crdate_year', 0)
        ];
        $records = $this->getRecordsByCriteria($queryBuilder, $this->table, $criteria);

        return $records;
    }
}
