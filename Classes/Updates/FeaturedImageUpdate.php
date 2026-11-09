<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates;

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard(FeaturedImageUpdate::class)]
final class FeaturedImageUpdate extends AbstractUpdate implements UpgradeWizardInterface, RepeatableInterface
{
    protected string $title = 'EXT:blog: Featured Image Update';

    public function updateNecessary(): bool
    {
        $records = $this->getAffectedRecords();
        return (bool) count($records);
    }

    public function executeUpdate(): bool
    {
        $records = $this->getAffectedRecords();
        foreach ($records as $record) {
            $this->updateRecord('sys_file_reference', (int) $record['uid'], [
                'fieldname' => 'featured_image',
            ]);
            $this->updateRecord('pages', (int) $record['uid_foreign'], [
                'featured_image' => 1,
                'media' => 0
            ]);
        }

        return true;
    }

    private function getAffectedPages(): array
    {
        $queryBuilder = $this->createQueryBuilder('pages');
        $criteria = [
            $this->createEqualIntCriteria($queryBuilder, 'doktype', Constants::DOKTYPE_BLOG_POST),
            $this->createEqualIntCriteria($queryBuilder, 'featured_image', 0),
            $this->createNotEqualIntCriteria($queryBuilder, 'media', 0),
        ];
        $records = $this->getRecordsByCriteria($queryBuilder, 'pages', $criteria);

        return $records;
    }

    private function getAffectedRecords(): array
    {
        $pages = array_map(
            function ($page) {
                return $page['uid'];
            },
            $this->getAffectedPages()
        );

        $queryBuilder = $this->createQueryBuilder('sys_file_reference');
        $criteria = [
            $this->createEqualStringCriteria($queryBuilder, 'tablenames', 'pages'),
            $this->createEqualStringCriteria($queryBuilder, 'fieldname', 'media'),
            $this->createInCriteria($queryBuilder, 'uid_foreign', $pages),
        ];
        $records = $this->getRecordsByCriteria($queryBuilder, 'sys_file_reference', $criteria);

        return $records;
    }
}
