<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

if (!defined('TYPO3')) {
    die('Access denied.');
}

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Posts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_posts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_posts.description',
    pluginIcon: 'plugin-blog-posts',
    group: 'blog',
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin, pages, recursive',
    'blog_posts',
    'after:palette:headers'
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'LatestPosts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_latestposts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_latestposts.description',
    pluginIcon: 'plugin-blog-posts',
    group: 'blog',
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin, pages, recursive',
    'blog_latestposts',
    'after:palette:headers'
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Category',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_category.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_category.description',
    pluginIcon: 'plugin-blog-category',
    group: 'blog',
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin, pages, recursive',
    'blog_category',
    'after:palette:headers'
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'AuthorPosts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authorposts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authorposts.description',
    pluginIcon: 'plugin-blog-authorposts',
    group: 'blog',
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin, pages, recursive',
    'blog_authorposts',
    'after:palette:headers'
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Tag',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_tag.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_tag.description',
    pluginIcon: 'plugin-blog-tag',
    group: 'blog',
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin, pages, recursive',
    'blog_tag',
    'after:palette:headers'
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Archive',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_archive.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_archive.description',
    pluginIcon: 'plugin-blog-archive',
    group: 'blog',
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin, pages, recursive',
    'blog_archive',
    'after:palette:headers'
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Sidebar',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_sidebar.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_sidebar.description',
    pluginIcon: 'plugin-blog-sidebar',
    group: 'blog',
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'CommentForm',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_commentform.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_commentform.description',
    pluginIcon: 'plugin-blog-sidebar',
    group: 'blog',
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Comments',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_comments.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_comments.description',
    pluginIcon: 'plugin-blog-comments',
    group: 'blog',
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Authors',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authors.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_authors.description',
    pluginIcon: 'plugin-blog-authors',
    group: 'blog',
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'DemandedPosts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_demandedposts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_demandedposts.description',
    pluginIcon: 'plugin-blog-demandedposts',
    group: 'blog',
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin, pi_flexform, pages, recursive',
    'blog_demandedposts',
    'after:palette:headers'
);
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:blog/Configuration/FlexForms/Demand.xml',
    'blog_demandedposts'
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'RelatedPosts',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_relatedposts.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_relatedposts.description',
    pluginIcon: 'plugin-blog-relatedposts',
    group: 'blog',
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Header',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_header.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_header.description',
    pluginIcon: 'plugin-blog-header',
    group: 'blog',
);

ExtensionUtility::registerPlugin(
    extensionName: 'Blog',
    pluginName: 'Footer',
    pluginTitle: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_footer.title',
    pluginDescription: 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_footer.description',
    pluginIcon: 'plugin-blog-footer',
    group: 'blog',
);
