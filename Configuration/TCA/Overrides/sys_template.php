<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Add static templates
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'blog',
    'Configuration/TypoScript/Integration/',
    'TYPO3 Blog: Integration'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'blog',
    'Configuration/TypoScript/Standalone/',
    'TYPO3 Blog: Standalone'
);
