<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates;

use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

final class TagSlugUpdate extends AbstractUpdate implements UpgradeWizardInterface
{
    /**
     * @var string
     */
    protected $title = 'EXT:blog: Generate Path-Segments for Tags';

    /**
     * @var string
     */
    protected $table = 'tx_blog_domain_model_tag';

    public function updateNecessary(): bool
    {
        $records = $this->getAffectedRecords();
        return (bool) count($records);
    }

    public function executeUpdate(): bool
    {
        $fieldConfig = $GLOBALS['TCA'][$this->table]['columns']['slug']['config'];
        $evalInfo = !empty($fieldConfig['eval']) ? GeneralUtility::trimExplode(',', $fieldConfig['eval'], true) : [];
        $hasToBeUniqueInSite = in_array('uniqueInSite', $evalInfo, true);
        $hasToBeUniqueInPid = in_array('uniqueInPid', $evalInfo, true);
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, $this->table, 'slug', $fieldConfig);

        $records = $this->getAffectedRecords();
        foreach ($records as $record) {
            $recordId = (int)$record['uid'];
            $pid = (int)$record['pid'];

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
            $this->updateRecord($this->table, $recordId, [
                'slug' => $slug
            ]);
        }

        return true;
    }

    private function getAffectedRecords(): array
    {
        $queryBuilder = $this->createQueryBuilder($this->table);
        $criteria = [
            $this->createEqualStringCriteria($queryBuilder, 'slug', ''),
            $this->createIsNullCriteria($queryBuilder, 'slug')
        ];
        $records = $this->getRecordsByCriteria($queryBuilder, $this->table, $criteria, AbstractUpdate::CONDITION_OR);

        return $records;
    }
}
