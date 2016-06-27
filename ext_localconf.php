<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'TYPO3.CMS.Blog',
    'Posts',
    array(
        'Post' => 'listRecentPosts, listPostsByTag, listPostsByCategory, show',
    ),
    array(
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'TYPO3.CMS.Blog',
    'RecentPostsWidget',
    array(
        'Post' => 'widgetRecentPosts',
    ),
    array(
    )
);
