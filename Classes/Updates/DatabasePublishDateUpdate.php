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
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard(DatabasePublishDateUpdate::class)]
final class DatabasePublishDateUpdate extends AbstractUpdate implements UpgradeWizardInterface
{
    protected string $title = 'EXT:blog: Set publish date fields to crdate for existing blog posts';
    protected string $table = 'pages';

    public function updateNecessary(): bool
    {
        $records = $this->getAffectedRecords();
        return (bool) count($records);
    }

    public function executeUpdate(): bool
    {
        $records = $this->getAffectedRecords();
        foreach ($records as $record) {
            $this->updateRecord($this->table, (int) $record['uid'], [
                'publish_date' => $record['crdate'] ?? time()
            ]);
        }

        return true;
    }

    private function getAffectedRecords(): array
    {
        $queryBuilder = $this->createQueryBuilder($this->table);
        $criteria = [
            $this->createEqualIntCriteria($queryBuilder, 'doktype', Constants::DOKTYPE_BLOG_POST),
            $this->createEqualIntCriteria($queryBuilder, 'publish_date', 0)
        ];
        $records = $this->getRecordsByCriteria($queryBuilder, $this->table, $criteria);

        return $records;
    }
}
