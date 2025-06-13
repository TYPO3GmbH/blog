<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use T3G\AgencyPack\Blog\Constants;

if (!defined('TYPO3')) {
    die('Access denied.');
}

// Add new page type:
$GLOBALS['PAGES_TYPES'][Constants::DOKTYPE_BLOG_POST] = [
    'type' => 'web',
    'allowedTables' => '*',
];
$GLOBALS['PAGES_TYPES'][Constants::DOKTYPE_BLOG_PAGE] = [
    'type' => 'web',
    'allowedTables' => '*',
];
