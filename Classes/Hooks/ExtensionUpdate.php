<?php

namespace T3G\AgencyPack\Blog\Hooks;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\Utility\InstallUtility;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class ExtensionUpdate
 */
class ExtensionUpdate {

    /**
     * available updates
     * @var array
     */
    protected $updates = [
        'migrateCommentsStatus'
    ];

    /**
     * @param string $extensionKey
     * @param InstallUtility $installUtilityInstance
     *
     * @throws \InvalidArgumentException
     */
    public function afterExtensionInstall($extensionKey, InstallUtility $installUtilityInstance)
    {
        if ($extensionKey !== 'blog') {
            return;
        }

        $registry = GeneralUtility::makeInstance(Registry::class);
        $appliedUpdates = $registry->get(__CLASS__, 'updates', []);
        foreach ($this->updates as $update) {
            if (!isset($appliedUpdates[$update])) {
                $result = $this->$update();
                if ($result) {
                    $appliedUpdates[$update] = true;
                }
            }
        }
        $registry->set(__CLASS__, 'updates', $appliedUpdates);
    }

    /**
     * @return bool
     */
    protected function migrateCommentsStatus()
    {
        $queries = [];
        $queries[] = 'UPDATE tx_blog_domain_model_comment SET `status` = 0 WHERE hidden = 1 AND deleted = 0';
        $queries[] = 'UPDATE tx_blog_domain_model_comment SET `status` = 10 WHERE hidden = 0 AND deleted = 0';
        $queries[] = 'UPDATE tx_blog_domain_model_comment SET `status` = 50 WHERE hidden = 1 AND deleted = 1';

        $databaseConnection = $this->getDatabaseConnection();
        foreach ($queries as $query) {
            $databaseConnection->sql_query($query);
        }
        return true;
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
       return $GLOBALS['TYPO3_DB'];
    }
}
