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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Posts',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_posts.title',
    'plugin-blog-posts'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_posts'] = 'select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'LatestPosts',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_latestposts.title',
    'plugin-blog-posts'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blog_latestposts'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'blog_latestposts',
    'FILE:EXT:blog/Configuration/FlexForms/LatestPosts.xml'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Category',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_category.title',
    'plugin-blog-category'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_category'] = 'select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'AuthorPosts',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authorposts.title',
    'plugin-blog-authorposts'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Tag',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_tag.title',
    'plugin-blog-tag'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_tag'] = 'select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Archive',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_archive.title',
    'plugin-blog-archive'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_archive'] = 'select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Sidebar',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_sidebar.title',
    'plugin-blog-sidebar'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_sidebar'] = 'recursive,select_key,pages';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Metadata',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_metadata.title',
    'plugin-blog-metadata'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_metadata'] = 'recursive,select_key,pages';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'CommentForm',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_commentform.title',
    'plugin-blog-commentform'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_commentform'] = 'recursive,select_key,pages';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Comments',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_comments.title',
    'plugin-blog-comments'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_comments'] = 'recursive,select_key,pages';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Authors',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authors.title',
    'plugin-blog-authors'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'RelatedPosts',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_relatedposts.title',
    'plugin-blog-relatedposts'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Header',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_header.title',
    'plugin-blog-header'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'T3G.AgencyPack.Blog',
    'Footer',
    'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_footer.title',
    'plugin-blog-footer'
);
