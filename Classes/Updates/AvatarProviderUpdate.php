<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates;

use T3G\AgencyPack\Blog\AvatarProvider\GravatarProvider;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard(AvatarProviderUpdate::class)]
final class AvatarProviderUpdate extends AbstractUpdate implements UpgradeWizardInterface
{
    protected string $title = 'EXT:blog: Migrate AvatarProvider';
    protected string $table = 'tx_blog_domain_model_author';

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
                'avatar_provider' => GravatarProvider::class
            ]);
        }

        return true;
    }

    private function getAffectedRecords(): array
    {
        $queryBuilder = $this->createQueryBuilder($this->table);
        $criteria = [$this->createEqualStringCriteria($queryBuilder, 'avatar_provider', '')];
        $records = $this->getRecordsByCriteria($queryBuilder, $this->table, $criteria);

        return $records;
    }
}
