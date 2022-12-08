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

// Make the extension configuration accessible
$extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
);
$blogConfiguration = $extensionConfiguration->get('blog');

// PageTS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:blog/Configuration/TsConfig/Page/All.tsconfig">');

// Register "blogvh" as global fluid namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['blogvh'][] = 'T3G\\AgencyPack\\Blog\\ViewHelpers';

// Register page layout hooks to display additional information for posts.
if (
    !(bool)$blogConfiguration['disablePageLayoutHeader'] &&
    (\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class))->getMajorVersion() < 12
) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook'][]
        = \T3G\AgencyPack\Blog\Hooks\PageLayoutHeaderHook::class . '->drawHeader';
}

// Register new form data provider
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\T3G\AgencyPack\Blog\Backend\FormDataProvider\CategoryDefaultValueProvider::class] = [
    'depends' => [\TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowInitializeNew::class],
    'after' => [\TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowInitializeNew::class],
];

// Overwrite create site configuration hook to include blog pages
if (class_exists('TYPO3\CMS\Core\Hooks\CreateSiteConfiguration')) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][\TYPO3\CMS\Core\Hooks\CreateSiteConfiguration::class]
        = \T3G\AgencyPack\Blog\Hooks\CreateSiteConfigurationHook::class;
}

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'Posts',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'listRecentPosts',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'DemandedPosts',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'listByDemand',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'LatestPosts',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'listLatestPosts',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'Category',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'listPostsByCategory',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'AuthorPosts',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'listPostsByAuthor',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'Tag',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'listPostsByTag',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'Archive',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'listPostsByDate',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'Sidebar',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'sidebar',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'CommentForm',
            [
                \T3G\AgencyPack\Blog\Controller\CommentController::class => 'form',
            ],
            [
                \T3G\AgencyPack\Blog\Controller\CommentController::class => 'form',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'Comments',
            [
                \T3G\AgencyPack\Blog\Controller\CommentController::class => 'comments',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'Header',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'header',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'Footer',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'footer',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'Authors',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'authors',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'RelatedPosts',
            [
                \T3G\AgencyPack\Blog\Controller\PostController::class => 'relatedPosts',
            ]
        );

        // Widgets
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'RecentPostsWidget',
            [
                \T3G\AgencyPack\Blog\Controller\WidgetController::class => 'recentPosts',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'CategoryWidget',
            [
                \T3G\AgencyPack\Blog\Controller\WidgetController::class => 'categories',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'TagWidget',
            [
                \T3G\AgencyPack\Blog\Controller\WidgetController::class => 'tags',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'CommentsWidget',
            [
                \T3G\AgencyPack\Blog\Controller\WidgetController::class => 'comments',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'ArchiveWidget',
            [
                \T3G\AgencyPack\Blog\Controller\WidgetController::class => 'archive',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Blog',
            'FeedWidget',
            [
                \T3G\AgencyPack\Blog\Controller\WidgetController::class => 'feed',
            ]
        );

        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['Blog'] =
            \T3G\AgencyPack\Blog\Hooks\DataHandlerHook::class;

        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['T3G\AgencyPack\Blog\Install\Updates\DatabaseMonthYearUpdate']
            = \T3G\AgencyPack\Blog\Updates\DatabaseMonthYearUpdate::class;
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['T3G\AgencyPack\Blog\Install\Updates\DatabasePublishDateUpdate']
            = \T3G\AgencyPack\Blog\Updates\DatabasePublishDateUpdate::class;
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['T3G\AgencyPack\Blog\Install\Updates\AvatarProviderUpdate']
            = \T3G\AgencyPack\Blog\Updates\AvatarProviderUpdate::class;
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\T3G\AgencyPack\Blog\Updates\CategorySlugUpdate::class]
            = \T3G\AgencyPack\Blog\Updates\CategorySlugUpdate::class;
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\T3G\AgencyPack\Blog\Updates\CategoryTypeUpdate::class]
            = \T3G\AgencyPack\Blog\Updates\CategoryTypeUpdate::class;
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\T3G\AgencyPack\Blog\Updates\AuthorSlugUpdate::class]
            = \T3G\AgencyPack\Blog\Updates\AuthorSlugUpdate::class;
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\T3G\AgencyPack\Blog\Updates\TagSlugUpdate::class]
            = \T3G\AgencyPack\Blog\Updates\TagSlugUpdate::class;
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\T3G\AgencyPack\Blog\Updates\FeaturedImageUpdate::class]
            = \T3G\AgencyPack\Blog\Updates\FeaturedImageUpdate::class;

        // Register Static Database Mapper
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['aspects']['BlogStaticDatabaseMapper'] =
            \T3G\AgencyPack\Blog\Routing\Aspect\StaticDatabaseMapper::class;

        // Register Notification visitors
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'][\T3G\AgencyPack\Blog\Notification\CommentAddedNotification::class][]
            = \T3G\AgencyPack\Blog\Notification\Processor\AdminNotificationProcessor::class;
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'][\T3G\AgencyPack\Blog\Notification\CommentAddedNotification::class][]
            = \T3G\AgencyPack\Blog\Notification\Processor\AuthorNotificationProcessor::class;
    }
);
