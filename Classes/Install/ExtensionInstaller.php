<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

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

use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\StreamOutput;
use TYPO3\CMS\Install\Updates\AbstractDownloadExtensionUpdate;
use TYPO3\CMS\Install\Updates\Confirmation;
use TYPO3\CMS\Install\Updates\ExtensionModel;

/**
 * Installs and downloads extension if needed.
 */
class ExtensionInstaller extends AbstractDownloadExtensionUpdate
{
    /**
     * @var array
     */
    protected $extensionDetails = [
        'blog_template' => [
            'title' => 'Blog template',
            'description' => 'blog template extension',
            'versionString' => '1.2.0',
            'composerName' => 't3g/blog-template'
        ],
        'rx_shariff' => [
            'title' => 'rx_shariff',
            'description' => 'rx_shariff',
            'versionString' => '10.2.1',
            'composerName' => 'reelworx/rx-shariff'
        ]
    ];

    /**
     * @param string $extensionKey
     * @return bool
     * @throws \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException
     */
    public function install(string $extensionKey): bool
    {
        $extension = new ExtensionModel(
            $extensionKey,
            $this->extensionDetails[$extensionKey]['title'],
            $this->extensionDetails[$extensionKey]['versionString'],
            $this->extensionDetails[$extensionKey]['composerName'],
            $this->extensionDetails[$extensionKey]['description']
        );
        $this->setOutput(new StreamOutput(fopen('php://temp', 'wb'), Output::VERBOSITY_NORMAL, false));
        return $this->installExtension($extension);
    }

    /**
     * Return a confirmation message instance
     *
     * @return \TYPO3\CMS\Install\Updates\Confirmation
     */
    public function getConfirmation(): Confirmation
    {
        throw new \RuntimeException('not implemented, this method should never be called', 1538678510);
    }

    /**
     * Return the identifier for this wizard
     * This should be the same string as used in the ext_localconf class registration
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        throw new \RuntimeException('not implemented, this method should never be called', 1538678511);
    }

    /**
     * Return the speaking name of this wizard
     *
     * @return string
     */
    public function getTitle(): string
    {
        throw new \RuntimeException('not implemented, this method should never be called', 1538678512);
    }

    /**
     * Return the description for this wizard
     *
     * @return string
     */
    public function getDescription(): string
    {
        throw new \RuntimeException('not implemented, this method should never be called', 1538678513);
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool
     */
    public function updateNecessary(): bool
    {
        throw new \RuntimeException('not implemented, this method should never be called', 1538678514);
    }

    /**
     * Returns an array of class names of Prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        throw new \RuntimeException('not implemented, this method should never be called', 1538678515);
    }
}
