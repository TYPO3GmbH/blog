<?php

namespace T3G\AgencyPack\Blog\Install;

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
use TYPO3\CMS\Install\Updates\AbstractDownloadExtensionUpdate;

/**
 * Installs and downloads extension if needed.
 */
class ExtensionInstaller extends AbstractDownloadExtensionUpdate
{
    /**
     * @var string
     */
    protected $extensionKey;

    /**
     * @var array
     */
    protected $extensionDetails = [
        'blog_template' => [
            'title' => 'Blog template',
            'description' => 'blog template extension',
            'versionString' => '1.2.0',
        ],
        'rx_shariff' => [
            'title' => 'rx_shariff',
            'description' => 'rx_shariff',
            'versionString' => '10.2.1',
        ]
    ];

    /**
     * ExtensionInstaller constructor.
     *
     * @param string $extensionKey
     */
    public function __construct($extensionKey)
    {
        $this->extensionKey = $extensionKey;
    }

    /**
     * Checks if an update is needed.
     *
     * @param string $description The description for the update
     *
     * @return bool Whether an update is needed (true) or not (false)
     */
    public function checkForUpdate(&$description)
    {
        return false;
    }

    /**
     * Performs the update.
     *
     * @param array $databaseQueries Queries done in this update
     * @param mixed $customMessages  Custom messages
     *
     * @return bool
     */
    public function performUpdate(array &$databaseQueries, &$customMessages)
    {
        $updateSuccessful = $this->installExtension($this->extensionKey, $customMessages);

        return $updateSuccessful;
    }
}
