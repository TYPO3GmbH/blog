<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

if (!defined('TYPO3')) {
    die('Access denied.');
}

$dokTypeRegistry = GeneralUtility::makeInstance(PageDoktypeRegistry::class);
$dokTypeRegistry->add(Constants::DOKTYPE_BLOG_POST, ['allowedTables' => '*']);
$dokTypeRegistry->add(Constants::DOKTYPE_BLOG_PAGE, ['allowedTables' => '*']);
