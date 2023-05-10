<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates;

use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

final class CommentStatusUpdate extends AbstractUpdate implements UpgradeWizardInterface
{
    /**
     * @var string
     */
    protected $title = 'EXT:blog: Migrate Comment Status';

    /**
     * @var string
     */
    protected $table = 'tx_blog_domain_model_comment';

    public function updateNecessary(): bool
    {
        $records = $this->getAffectedRecords();
        return (bool) count($records);
    }

    public function executeUpdate(): bool
    {
        $records = $this->getAffectedRecords();
        foreach ($records as $record) {
            $status = 0;
            if ($record['status'] === 0 && $record['hidden'] === 0 && $record['deleted'] === 0) {
                $status = 10;
            } elseif ($record['status'] === 0 && $record['hidden'] === 1 && $record['deleted'] === 1) {
                $status = 50;
            }
            $this->updateRecord($this->table, (int) $record['uid'], [
                'status' => (string) $status
            ]);
        }

        return true;
    }

    private function getAffectedRecords(): array
    {
        $records = [];
        $queryBuilder = $this->createQueryBuilder($this->table);

        // Status 10
        array_push($records, ...$this->getRecordsByCriteria($queryBuilder, $this->table, [
            $this->createEqualIntCriteria($queryBuilder, 'status', 0),
            $this->createEqualIntCriteria($queryBuilder, 'hidden', 0),
            $this->createEqualIntCriteria($queryBuilder, 'deleted', 0),
        ]));

        // Status 50
        array_push($records, ...$this->getRecordsByCriteria($queryBuilder, $this->table, [
            $this->createEqualIntCriteria($queryBuilder, 'status', 0),
            $this->createEqualIntCriteria($queryBuilder, 'hidden', 1),
            $this->createEqualIntCriteria($queryBuilder, 'deleted', 1),
        ]));

        return $records;
    }
}
