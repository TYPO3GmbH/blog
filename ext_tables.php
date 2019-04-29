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

call_user_func(function () {
    $blogDocType = \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST;

    // Add new page type:
    $GLOBALS['PAGES_TYPES'][$blogDocType] = [
        'type' => 'web',
        'allowedTables' => '*',
    ];

    // Provide icon for page tree, list view, ... :
    $icons = [
        'blog-link-wizard' => 'EXT:blog/Resources/Public/Icons/blog-link-wizard.svg',
        'apps-pagetree-folder-contains-blog' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-folder-contains-blog.svg',
        'apps-pagetree-blog' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog.svg',
        'apps-pagetree-blog-author' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-author.svg',
        'apps-pagetree-blog-category' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-category.svg',
        'apps-pagetree-blog-comment' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment.svg',
        'apps-pagetree-blog-comment-approved' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment-approved.svg',
        'apps-pagetree-blog-comment-blocked' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment-blocked.svg',
        'apps-pagetree-blog-comment-todo' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment-todo.svg',
        'apps-pagetree-blog-post' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-post.svg',
        'apps-pagetree-blog-tag' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-tag.svg',
        'plugin-blog-archive' => 'EXT:blog/Resources/Public/Icons/plugin-blog-archive.svg',
        'plugin-blog-authorposts' => 'EXT:blog/Resources/Public/Icons/plugin-blog-authorposts.svg',
        'plugin-blog-authors' => 'EXT:blog/Resources/Public/Icons/plugin-blog-authors.svg',
        'plugin-blog-category' => 'EXT:blog/Resources/Public/Icons/plugin-blog-category.svg',
        'plugin-blog-commentform' => 'EXT:blog/Resources/Public/Icons/plugin-blog-commentform.svg',
        'plugin-blog-comments' => 'EXT:blog/Resources/Public/Icons/plugin-blog-comments.svg',
        'plugin-blog-metadata' => 'EXT:blog/Resources/Public/Icons/plugin-blog-metadata.svg',
        'plugin-blog-posts' => 'EXT:blog/Resources/Public/Icons/plugin-blog-posts.svg',
        'plugin-blog-relatedposts' => 'EXT:blog/Resources/Public/Icons/plugin-blog-relatedposts.svg',
        'plugin-blog-sidebar' => 'EXT:blog/Resources/Public/Icons/plugin-blog-sidebar.svg',
        'plugin-blog-tag' => 'EXT:blog/Resources/Public/Icons/plugin-blog-tag.svg',

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
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
        'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $blogDocType . ')'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_blog_domain_model_comment');

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Posts',
        'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_posts.title',
        'plugin-blog-posts'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Category',
        'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_category.title',
        'plugin-blog-category'
    );
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
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Archive',
        'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_archive.title',
        'plugin-blog-archive'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Sidebar',
        'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_sidebar.title',
        'plugin-blog-sidebar'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Metadata',
        'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_metadata.title',
        'plugin-blog-metadata'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'CommentForm',
        'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_commentform.title',
        'plugin-blog-commentform'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Comments',
        'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_comments.title',
        'plugin-blog-comments'
    );
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

    if (TYPO3_MODE === 'BE') {
        // Module Web > Blog
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'T3G.AgencyPack.Blog',
            'web',
            'tx_Blog',
            'bottom',
            [
                'Backend' => 'posts, comments, updateCommentStatus',
            ],
            [
                'access' => 'user,group',
                'icon' => 'EXT:blog/Resources/Public/Icons/module-blog.svg',
                'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod.xlf',
            ]
        );
        unset($GLOBALS['TBE_MODULES']['_configuration']['web_BlogTxBlog']['navigationComponentId']);

        // Module System > Web
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'T3G.AgencyPack.Blog',
            'system',
            'tx_Blog',
            'top',
            [
                'Backend' => 'setupWizard, createBlog',
            ],
            [
                'access' => 'admin',
                'icon' => 'EXT:blog/Resources/Public/Icons/module-blog.svg',
                'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod.xlf',
            ]
        );
    }
});
