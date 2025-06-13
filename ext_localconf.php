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
use T3G\AgencyPack\Blog\Notification\CommentAddedNotification;
use T3G\AgencyPack\Blog\Notification\Processor\AdminNotificationProcessor;
use T3G\AgencyPack\Blog\Notification\Processor\AuthorNotificationProcessor;
use T3G\AgencyPack\Blog\Routing\Aspect\StaticDatabaseMapper;
use TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowInitializeNew;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

if (!defined('TYPO3')) {
    die('Access denied.');
}

// Register "blogvh" as global fluid namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['blogvh'][] = 'T3G\\AgencyPack\\Blog\\ViewHelpers';

// Register new form data provider
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][CategoryDefaultValueProvider::class] = [
    'depends' => [DatabaseRowInitializeNew::class],
    'after' => [DatabaseRowInitializeNew::class],
];

// Register site configuration hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][CreateSiteConfigurationHook::class]
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

// Register Static Database Mapper
$GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['aspects']['BlogStaticDatabaseMapper']
    = StaticDatabaseMapper::class;

// Register Notification visitors
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'][CommentAddedNotification::class][]
    = AdminNotificationProcessor::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'][CommentAddedNotification::class][]
    = AuthorNotificationProcessor::class;
