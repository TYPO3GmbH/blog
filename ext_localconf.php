<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
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
    ],
    [
        'Post' => 'listPostsByCategory',
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
    ],
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
    'Meta',
    [
        'Post' => 'metadata',
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

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['blog'] =
        \T3G\AgencyPack\Blog\Hooks\RealUrlAutoConfiguration::class . '->addBlogConfiguration';
}
