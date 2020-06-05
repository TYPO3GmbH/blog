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

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'Posts',
        'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_posts.title',
        'plugin-blog-posts'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'T3G.AgencyPack.Blog',
        'LatestPosts',
        'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:plugin.blog_latestposts.title',
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

    if (TYPO3_MODE === 'BE') {

        // Module Blog
        if (version_compare(
            \TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version(),
            '10.4.0',
            'lt'
        )) {
            $firstKey = array_key_first($GLOBALS['TBE_MODULES']);
            $firstValue = array_shift($GLOBALS['TBE_MODULES']);
            $GLOBALS['TBE_MODULES'] = array_merge([$firstKey => $firstValue, 'blog' => ''], $GLOBALS['TBE_MODULES']);
            $GLOBALS['TBE_MODULES']['_configuration']['blog'] = [
                'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog.xlf',
                'name' => 'blog',
                'iconIdentifier' => 'module-blog'
            ];
        } else {
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
        }

        // Module Blog > Posts
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'T3G.AgencyPack.Blog',
            'blog',
            'blog_posts',
            '',
            [
                'Backend' => 'posts',
            ],
            [
                'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_posts.xlf',
                'icon' => 'EXT:blog/Resources/Public/Icons/module-blog-posts.svg',
                'access' => 'user,group',
            ]
        );

        // Module Blog > Comments
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'T3G.AgencyPack.Blog',
            'blog',
            'blog_comments',
            '',
            [
                'Backend' => 'comments, updateCommentStatus',
            ],
            [
                'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_comments.xlf',
                'icon' => 'EXT:blog/Resources/Public/Icons/module-blog-comments.svg',
                'access' => 'user,group',
            ]
        );

        // Module Blog > Setup
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'T3G.AgencyPack.Blog',
            'blog',
            'blog_setup',
            '',
            [
                'Backend' => 'setupWizard, createBlog',
            ],
            [
                'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_setup.xlf',
                'icon' => 'EXT:blog/Resources/Public/Icons/module-blog-setup.svg',
                'access' => 'admin',
            ]
        );
    }
});
