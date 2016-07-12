<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'Posts',
    [
        'Post' => 'listRecentPosts, listPostsByTag, listPostsByCategory',
    ],
    [
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'Sidebar',
    [
        'Post' => 'sidebar',
    ],
    [
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'CommentForm',
    [
        'Comment' => 'form, addComment',
    ],
    [
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'Comments',
    [
        'Comment' => 'comments',
    ],
    [
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'Meta',
    [
        'Post' => 'metadata',
    ],
    [
    ]
);

// Widgets
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'RecentPostsWidget',
    [
        'Post' => 'widgetRecentPosts',
    ],
    [
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'CategoryWidget',
    [
        'Post' => 'widgetCategories',
    ],
    [
    ]
);
