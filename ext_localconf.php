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

/***************
 * Load Dependencies
 */
if (!interface_exists('Psr\Http\Client\ClientInterface') ||
    !interface_exists('Psr\Http\Message\RequestInterface') ||
    !interface_exists('Psr\Http\Message\RequestFactoryInterface')
) {
    require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('blog') . '/Resources/Private/PHP/vendor/autoload.php';
}

/***************
 * Make the extension configuration accessible
 */
$extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
);
$blogConfiguration = $extensionConfiguration->get('blog');

/***************
 * PageTS
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:blog/Configuration/TsConfig/Page/All.tsconfig">');

/***************
 * Register "blogvh" as global fluid namespace
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['blogvh'][] = 'T3G\\AgencyPack\\Blog\\ViewHelpers';

/***************
 * Register page layout hooks to display additional information for posts.
 */
if (!(bool) $blogConfiguration['disablePageLayoutHeader']) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook'][]
        = \T3G\AgencyPack\Blog\Hooks\PageLayoutHeaderHook::class . '->drawHeader';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['recordlist/Modules/Recordlist/index.php']['drawHeaderHook'][]
        = \T3G\AgencyPack\Blog\Hooks\PageLayoutHeaderHook::class . '->drawHeader';
}

/***************
 * Register new form data provider
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\T3G\AgencyPack\Blog\Backend\FormDataProvider\CategoryDefaultValueProvider::class] = [
    'depends' => [\TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowInitializeNew::class],
    'after' => [\TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowInitializeNew::class],
];

/***************
 * Overwrite create site configuration hook to include blog pages
 */
if (class_exists('TYPO3\CMS\Core\Hooks\CreateSiteConfiguration')) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][\TYPO3\CMS\Core\Hooks\CreateSiteConfiguration::class]
        = \T3G\AgencyPack\Blog\Hooks\CreateSiteConfigurationHook::class;
}

call_user_func(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Posts',
        [
            'Post' => 'listRecentPosts',
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'LatestPosts',
        [
            'Post' => 'listLatestPosts',
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Category',
        [
            'Post' => 'listPostsByCategory',
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'AuthorPosts',
        [
            'Post' => 'listPostsByAuthor',
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Tag',
        [
            'Post' => 'listPostsByTag',
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Archive',
        [
            'Post' => 'listPostsByDate',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Sidebar',
        [
            'Post' => 'sidebar',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'CommentForm',
        [
            'Comment' => 'form',
        ],
        [
            'Comment' => 'form',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Comments',
        [
            'Comment' => 'comments',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Header',
        [
            'Post' => 'header',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Footer',
        [
            'Post' => 'footer',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Metadata',
        [
            'Post' => 'metadata',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Authors',
        [
            'Post' => 'authors',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'RelatedPosts',
        [
            'Post' => 'relatedPosts',
        ]
    );

    // Widgets
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'RecentPostsWidget',
        [
            'Widget' => 'recentPosts',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'CategoryWidget',
        [
            'Widget' => 'categories',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'TagWidget',
        [
            'Widget' => 'tags',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'CommentsWidget',
        [
            'Widget' => 'comments',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'ArchiveWidget',
        [
            'Widget' => 'archive',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'FeedWidget',
        [
            'Widget' => 'feed',
        ]
    );

    $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $dispatcher->connect(
        \TYPO3\CMS\Extensionmanager\Utility\InstallUtility::class,
        'afterExtensionInstall',
        \T3G\AgencyPack\Blog\Hooks\ExtensionUpdate::class,
        'afterExtensionInstall'
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
});
