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
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'T3G.AgencyPack.Blog',
        'Posts',
        [
            'Post' => 'listRecentPosts',
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
            'Comment' => 'form, addComment',
        ],
        [
            'Comment' => 'form, addComment',
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

    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
        /** @noinspection UnsupportedStringOffsetOperationsInspection */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['blog']
            = \T3G\AgencyPack\Blog\Hooks\RealUrlAutoConfiguration::class .
            '->addBlogConfiguration';
    }

    // Register Social Image Wizard
    /** @noinspection UnsupportedStringOffsetOperationsInspection */
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1506942138] = [
        'nodeName' => 'BlogSocialImageWizard',
        'priority' => 20,
        'class' => \T3G\AgencyPack\Blog\Form\Wizards\SocialWizard::class
    ];

    // Register Notification visitors
    /** @noinspection UnsupportedStringOffsetOperationsInspection */
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'][\T3G\AgencyPack\Blog\Notification\CommentAddedNotification::class][]
        = \T3G\AgencyPack\Blog\Notification\Processor\AdminNotificationProcessor::class;
    /** @noinspection UnsupportedStringOffsetOperationsInspection */
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'][\T3G\AgencyPack\Blog\Notification\CommentAddedNotification::class][]
        = \T3G\AgencyPack\Blog\Notification\Processor\AuthorNotificationProcessor::class;
});
