<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

call_user_func(
    function ($extKey, $table) {
        $extRelPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey);
        $customPageIcon = $extRelPath . 'Resources/Public/Icons/apps-pagetree-blog-post.svg';
        $blogDocType = \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST;

        // Add new page type as possible select item:
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'doktype',
            [
                'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_tca.xlf:pages.doktype.blog-post',
                $blogDocType,
                $customPageIcon,
            ],
            '1',
            'after'
        );
    },
    'blog',
    'pages_language_overlay'
);
