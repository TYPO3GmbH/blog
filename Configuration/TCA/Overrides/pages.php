<?php
defined('TYPO3_MODE') or die();

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
                $customPageIcon
            ],
            '1',
            'after'
        );

        // Add icon for new page type:
        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
            $GLOBALS['TCA']['pages'],
            [
                'ctrl' => [
                    'typeicon_classes' => [
                        $blogDocType => 'apps-pagetree-blog-post',
                    ],
                ],
                'types' => [
                    (string)\T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST
                    => $GLOBALS['TCA']['pages']['types'][\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT]
                ]
            ]
        );


        $ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';
        $temporaryColumns = array (
            'comments_active' => [
                'exclude' => 1,
                'label' => $ll . 'pages.comments_active',
                'config' => [
                    'type' => 'check',
                    'default' => '1',
                ]
            ],
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
            'pages',
            $temporaryColumns
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            'pages',
            '--div--;' . $ll . 'pages.tabs.blog, comments_active',
            (string)\T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST
        );
    },
    'blog',
    'pages'
);
