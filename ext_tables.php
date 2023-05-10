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

call_user_func(function () {
    // Add new page type:
    $GLOBALS['PAGES_TYPES'][\T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST] = [
        'type' => 'web',
        'allowedTables' => '*',
    ];
    $GLOBALS['PAGES_TYPES'][\T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_PAGE] = [
        'type' => 'web',
        'allowedTables' => '*',
    ];

    // Provide icon for page tree, list view, ... :
    $icons = [
        'actions-approve' => 'EXT:blog/Resources/Public/Icons/actions-approve.svg',
        'actions-decline' => 'EXT:blog/Resources/Public/Icons/actions-decline.svg',
        'module-blog' => 'EXT:blog/Resources/Public/Icons/module-blog.svg',
        'plugin-blog-archive' => 'EXT:blog/Resources/Public/Icons/plugin-blog-archive.svg',
        'plugin-blog-authorposts' => 'EXT:blog/Resources/Public/Icons/plugin-blog-authorposts.svg',
        'plugin-blog-authors' => 'EXT:blog/Resources/Public/Icons/plugin-blog-authors.svg',
        'plugin-blog-category' => 'EXT:blog/Resources/Public/Icons/plugin-blog-category.svg',
        'plugin-blog-commentform' => 'EXT:blog/Resources/Public/Icons/plugin-blog-commentform.svg',
        'plugin-blog-comments' => 'EXT:blog/Resources/Public/Icons/plugin-blog-comments.svg',
        'plugin-blog-demandedposts' => 'EXT:blog/Resources/Public/Icons/plugin-blog-demandedposts.svg',
        'plugin-blog-header' => 'EXT:blog/Resources/Public/Icons/plugin-blog-header.svg',
        'plugin-blog-footer' => 'EXT:blog/Resources/Public/Icons/plugin-blog-footer.svg',
        'plugin-blog-metadata' => 'EXT:blog/Resources/Public/Icons/plugin-blog-metadata.svg',
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
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach ($icons as $identifier => $path) {
        $iconRegistry->registerIcon(
            $identifier,
            TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => $path]
        );
    }

    // Allow backend users to drag and drop the new page type:
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
        options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST . ')
    ');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_blog_domain_model_comment');

    // Main Blog
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
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
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Blog',
        'blog',
        'blog_posts',
        '',
        [
            \T3G\AgencyPack\Blog\Controller\BackendController::class => 'posts',
        ],
        [
            'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_posts.xlf',
            'icon' => 'EXT:blog/Resources/Public/Icons/module-blog-posts.svg',
            'access' => 'user,group',
        ]
    );
    // Module Blog > Comments
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Blog',
        'blog',
        'blog_comments',
        '',
        [
            \T3G\AgencyPack\Blog\Controller\BackendController::class => 'comments, updateCommentStatus',
        ],
        [
            'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_comments.xlf',
            'icon' => 'EXT:blog/Resources/Public/Icons/module-blog-comments.svg',
            'access' => 'user,group',
        ]
    );
    // Module Blog > Setup
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Blog',
        'blog',
        'blog_setup',
        '',
        [
            \T3G\AgencyPack\Blog\Controller\BackendController::class => 'setupWizard, createBlog',
        ],
        [
            'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_setup.xlf',
            'icon' => 'EXT:blog/Resources/Public/Icons/module-blog-setup.svg',
            'access' => 'admin',
        ]
    );
});
