<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Add static template
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('blog', 'Configuration/TypoScript/Static/', 'TYPO3 Blog');
