<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'Posts',
    array(
        'Post' => 'listRecentPosts, listPostsByTag, listPostsByCategory',
    ),
    array(
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'Sidebar',
    array(
        'Post' => 'sidebar',
    ),
    array(
    )
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'Meta',
    array(
        'Post' => 'metadata',
    ),
    array(
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'T3G.AgencyPack.Blog',
    'RecentPostsWidget',
    array(
        'Post' => 'widgetRecentPosts',
    ),
    array(
    )
);
