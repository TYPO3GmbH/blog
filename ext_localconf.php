<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use T3G\AgencyPack\Blog\Backend\FormDataProvider\CategoryDefaultValueProvider;
use T3G\AgencyPack\Blog\Controller\CommentController;
use T3G\AgencyPack\Blog\Controller\PostController;
use T3G\AgencyPack\Blog\Controller\WidgetController;
use T3G\AgencyPack\Blog\Hooks\CreateSiteConfigurationHook;
use T3G\AgencyPack\Blog\Hooks\DataHandlerHook;
use T3G\AgencyPack\Blog\Hooks\PageLayoutHeaderHook;
use T3G\AgencyPack\Blog\Notification\CommentAddedNotification;
use T3G\AgencyPack\Blog\Notification\Processor\AdminNotificationProcessor;
use T3G\AgencyPack\Blog\Notification\Processor\AuthorNotificationProcessor;
use T3G\AgencyPack\Blog\Routing\Aspect\StaticDatabaseMapper;
use T3G\AgencyPack\Blog\Updates\AuthorSlugUpdate;
use T3G\AgencyPack\Blog\Updates\AvatarProviderUpdate;
use T3G\AgencyPack\Blog\Updates\CategorySlugUpdate;
use T3G\AgencyPack\Blog\Updates\CategoryTypeUpdate;
use T3G\AgencyPack\Blog\Updates\CommentStatusUpdate;
use T3G\AgencyPack\Blog\Updates\DatabaseMonthYearUpdate;
use T3G\AgencyPack\Blog\Updates\DatabasePublishDateUpdate;
use T3G\AgencyPack\Blog\Updates\FeaturedImageUpdate;
use T3G\AgencyPack\Blog\Updates\TagSlugUpdate;
use TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowInitializeNew;
use TYPO3\CMS\Core\Hooks\CreateSiteConfiguration;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

if (!defined('TYPO3')) {
    die('Access denied.');
}

// PageTS
ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:blog/Configuration/TsConfig/Page/All.tsconfig">');

// Register "blogvh" as global fluid namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['blogvh'][] = 'T3G\\AgencyPack\\Blog\\ViewHelpers';

// Register page layout hooks to display additional information for posts.
// Replaced with T3G\AgencyPack\Blog\Listener\ModifyPageLayoutContent in v12
if ((GeneralUtility::makeInstance(Typo3Version::class))->getMajorVersion() < 12) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook'][]
       = PageLayoutHeaderHook::class . '->drawHeader';
}

// Register new form data provider
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][CategoryDefaultValueProvider::class] = [
    'depends' => [DatabaseRowInitializeNew::class],
    'after' => [DatabaseRowInitializeNew::class],
];

// Overwrite create site configuration hook to include blog pages
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][CreateSiteConfiguration::class]
    = CreateSiteConfigurationHook::class;

ExtensionUtility::configurePlugin(
    'Blog',
    'Posts',
    [
        PostController::class => 'listRecentPosts',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'DemandedPosts',
    [
        PostController::class => 'listByDemand',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'LatestPosts',
    [
        PostController::class => 'listLatestPosts',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'Category',
    [
        PostController::class => 'listPostsByCategory',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'AuthorPosts',
    [
        PostController::class => 'listPostsByAuthor',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'Tag',
    [
        PostController::class => 'listPostsByTag',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'Archive',
    [
        PostController::class => 'listPostsByDate',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'Sidebar',
    [
        PostController::class => 'sidebar',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'CommentForm',
    [
        CommentController::class => 'form',
    ],
    [
        CommentController::class => 'form',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'Comments',
    [
        CommentController::class => 'comments',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'Header',
    [
        PostController::class => 'header',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'Footer',
    [
        PostController::class => 'footer',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'Authors',
    [
        PostController::class => 'authors',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'RelatedPosts',
    [
        PostController::class => 'relatedPosts',
    ]
);

// Widgets
ExtensionUtility::configurePlugin(
    'Blog',
    'RecentPostsWidget',
    [
        WidgetController::class => 'recentPosts',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'CategoryWidget',
    [
        WidgetController::class => 'categories',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'TagWidget',
    [
        WidgetController::class => 'tags',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'CommentsWidget',
    [
        WidgetController::class => 'comments',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'ArchiveWidget',
    [
        WidgetController::class => 'archive',
    ]
);

ExtensionUtility::configurePlugin(
    'Blog',
    'FeedWidget',
    [
        WidgetController::class => 'feed',
    ]
);

// Hooks
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['Blog']
    = DataHandlerHook::class;

// Upgrades
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][AuthorSlugUpdate::class]
    = AuthorSlugUpdate::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][AvatarProviderUpdate::class]
    = AvatarProviderUpdate::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][CategorySlugUpdate::class]
    = CategorySlugUpdate::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][CategoryTypeUpdate::class]
    = CategoryTypeUpdate::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][CommentStatusUpdate::class]
    = CommentStatusUpdate::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][DatabaseMonthYearUpdate::class]
    = DatabaseMonthYearUpdate::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][DatabasePublishDateUpdate::class]
    = DatabasePublishDateUpdate::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][FeaturedImageUpdate::class]
    = FeaturedImageUpdate::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][TagSlugUpdate::class]
    = TagSlugUpdate::class;

// Register Static Database Mapper
$GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['aspects']['BlogStaticDatabaseMapper']
    = StaticDatabaseMapper::class;

// Register Notification visitors
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'][CommentAddedNotification::class][]
    = AdminNotificationProcessor::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'][CommentAddedNotification::class][]
    = AuthorNotificationProcessor::class;
