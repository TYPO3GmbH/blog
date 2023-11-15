<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Controller\BackendController;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

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

// Provide icon for page tree, list view, ... :
$icons = [
    'actions-approve' => 'EXT:blog/Resources/Public/Icons/actions-approve.svg',
    'actions-decline' => 'EXT:blog/Resources/Public/Icons/actions-decline.svg',
    'module-blog' => 'EXT:blog/Resources/Public/Icons/module-blog.svg',
    'module-blog-posts' => 'EXT:blog/Resources/Public/Icons/module-blog-posts.svg',
    'module-blog-comments' => 'EXT:blog/Resources/Public/Icons/module-blog-comments.svg',
    'module-blog-setup' => 'EXT:blog/Resources/Public/Icons/module-blog-setup.svg',
    'plugin-blog-archive' => 'EXT:blog/Resources/Public/Icons/plugin-blog-archive.svg',
    'plugin-blog-authorposts' => 'EXT:blog/Resources/Public/Icons/plugin-blog-authorposts.svg',
    'plugin-blog-authors' => 'EXT:blog/Resources/Public/Icons/plugin-blog-authors.svg',
    'plugin-blog-category' => 'EXT:blog/Resources/Public/Icons/plugin-blog-category.svg',
    'plugin-blog-commentform' => 'EXT:blog/Resources/Public/Icons/plugin-blog-commentform.svg',
    'plugin-blog-comments' => 'EXT:blog/Resources/Public/Icons/plugin-blog-comments.svg',
    'plugin-blog-demandedposts' => 'EXT:blog/Resources/Public/Icons/plugin-blog-demandedposts.svg',
    'plugin-blog-header' => 'EXT:blog/Resources/Public/Icons/plugin-blog-header.svg',
    'plugin-blog-footer' => 'EXT:blog/Resources/Public/Icons/plugin-blog-footer.svg',
    'plugin-blog-posts' => 'EXT:blog/Resources/Public/Icons/plugin-blog-posts.svg',
    'plugin-blog-relatedposts' => 'EXT:blog/Resources/Public/Icons/plugin-blog-relatedposts.svg',
    'plugin-blog-sidebar' => 'EXT:blog/Resources/Public/Icons/plugin-blog-sidebar.svg',
    'plugin-blog-tag' => 'EXT:blog/Resources/Public/Icons/plugin-blog-tag.svg',
    'record-blog-author' => 'EXT:blog/Resources/Public/Icons/record-blog-author.svg',
    'record-blog-comment' => 'EXT:blog/Resources/Public/Icons/record-blog-comment.svg',
    'record-blog-page' => 'EXT:blog/Resources/Public/Icons/record-blog-page.svg',
    'record-blog-page-root' => 'EXT:blog/Resources/Public/Icons/record-blog-page-root.svg',
    'record-blog-post' => 'EXT:blog/Resources/Public/Icons/record-blog-post.svg',
    'record-blog-tag' => 'EXT:blog/Resources/Public/Icons/record-blog-tag.svg',
    'record-blog-category' => 'EXT:blog/Resources/Public/Icons/record-blog-category.svg',
    'record-folder-contains-blog' => 'EXT:blog/Resources/Public/Icons/record-folder-contains-blog.svg',
];

$iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
foreach ($icons as $identifier => $path) {
    $iconRegistry->registerIcon($identifier, SvgIconProvider::class, ['source' => $path]);
}

// Allow backend users to drag and drop the new page type:
ExtensionManagementUtility::addUserTSConfig('
    options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . Constants::DOKTYPE_BLOG_POST . ')
');

if ((GeneralUtility::makeInstance(Typo3Version::class))->getMajorVersion() < 12) {
    ExtensionManagementUtility::allowTableOnStandardPages('tx_blog_domain_model_comment');
}

if ((GeneralUtility::makeInstance(Typo3Version::class))->getMajorVersion() < 12) {
    // Main Blog
    ExtensionManagementUtility::addModule(
        'blog',
        '',
        'after:web',
        null,
        [
            'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog.xlf',
            'name' => 'blog',
            'iconIdentifier' => 'module-blog',
        ]
    );

    // Module Blog > Posts
    ExtensionUtility::registerModule(
        'Blog',
        'blog',
        'blog_posts',
        '',
        [
            BackendController::class => 'posts',
        ],
        [
            'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_posts.xlf',
            'iconIdentifier' => 'module-blog-posts',
            'access' => 'user,group',
        ]
    );

    // Module Blog > Comments
    ExtensionUtility::registerModule(
        'Blog',
        'blog',
        'blog_comments',
        '',
        [
            BackendController::class => 'comments, updateCommentStatus',
        ],
        [
            'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_comments.xlf',
            'iconIdentifier' => 'module-blog-comments',
            'access' => 'user,group',
        ]
    );

    // Module Blog > Setup
    ExtensionUtility::registerModule(
        'Blog',
        'blog',
        'blog_setup',
        '',
        [
            BackendController::class => 'setupWizard, createBlog',
        ],
        [
            'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_setup.xlf',
            'iconIdentifier' => 'module-blog-setup',
            'access' => 'admin',
        ]
    );
}
