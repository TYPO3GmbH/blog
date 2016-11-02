<?php

defined('TYPO3_MODE') or die();

// Add static template
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('blog', 'Configuration/TypoScript/Static/', 'TYPO3 Blog');
