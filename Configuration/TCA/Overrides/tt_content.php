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

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_archive'] = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_commentform'] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_comments'] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_category'] = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_tag'] = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_posts'] = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_metadata'] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_sidebar'] = 'recursive,select_key,pages';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blog_posts'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'blog_posts',
    'FILE:EXT:blog/Configuration/FlexForms/ListPosts.xml'
);
