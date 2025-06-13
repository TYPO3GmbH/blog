<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

if (!defined('TYPO3')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Posts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_posts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_posts.description',
    pluginIcon: 'plugin-blog-posts',
    group: 'blog',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_posts'] = 'select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'LatestPosts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_latestposts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_latestposts.description',
    pluginIcon: 'plugin-blog-posts',
    group: 'blog',
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Category',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_category.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_category.description',
    pluginIcon: 'plugin-blog-category',
    group: 'blog',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_category'] = 'select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'AuthorPosts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authorposts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authorposts.description',
    pluginIcon: 'plugin-blog-authorposts',
    group: 'blog',
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Tag',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_tag.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_tag.description',
    pluginIcon: 'plugin-blog-tag',
    group: 'blog',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_tag'] = 'select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Archive',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_archive.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_archive.description',
    pluginIcon: 'plugin-blog-archive',
    group: 'blog',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_archive'] = 'select_key';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Sidebar',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_sidebar.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_sidebar.description',
    pluginIcon: 'plugin-blog-sidebar',
    group: 'blog',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_sidebar'] = 'recursive,select_key,pages';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'CommentForm',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_commentform.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_commentform.description',
    pluginIcon: 'plugin-blog-sidebar',
    group: 'blog',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_commentform'] = 'recursive,select_key,pages';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Comments',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_comments.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_comments.description',
    pluginIcon: 'plugin-blog-comments',
    group: 'blog',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['blog_comments'] = 'recursive,select_key,pages';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Authors',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authors.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authors.description',
    pluginIcon: 'plugin-blog-authors',
    group: 'blog',
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'DemandedPosts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_demandedposts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_demandedposts.description',
    pluginIcon: 'plugin-blog-demandedposts',
    group: 'blog',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blog_demandedposts'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'blog_demandedposts',
    'FILE:EXT:blog/Configuration/FlexForms/Demand.xml'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'RelatedPosts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_relatedposts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_relatedposts.description',
    pluginIcon: 'plugin-blog-relatedposts',
    group: 'blog',
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Header',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_header.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_header.description',
    pluginIcon: 'plugin-blog-header',
    group: 'blog',
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Footer',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_footer.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_footer.description',
    pluginIcon: 'plugin-blog-footer',
    group: 'blog',
);
