<?php

defined('TYPO3_MODE') or die();

$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod.xlf:blog-folder',
    1 => 'blog',
    2 => 'apps-pagetree-folder-contains-blog'
];

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
                    (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST => $GLOBALS['TCA']['pages']['types'][\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT],
                ],
            ]
        );

        $ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';
        $temporaryColumns = [
            'comments_active' => [
                'exclude' => 1,
                'label' => $ll . 'pages.comments_active',
                'config' => [
                    'type' => 'check',
                    'default' => '1',
                ],
            ],
            'comments' => [
                'exclude' => 1,
                'label' => $ll . 'pages.comments',
                'config' => [
                    'type' => 'inline',
                    'foreign_table' => 'tx_blog_domain_model_comment',
                    'foreign_field' => 'parentid',
                    'foreign_table_field' => 'parenttable',
                    'size' => 10,
                    'maxitems' => 9999,
                    'autoSizeMax' => 30,
                    'multiple' => 0,
                    'appearance' => [
                        'collapseAll' => 1,
                        'levelLinksPosition' => 'top',
                        'showSynchronizationLink' => 1,
                        'showPossibleLocalizationRecords' => 1,
                        'showAllLocalizationLink' => 1,
                    ],
                ],
            ],
            'sharing_enabled' => [
                'exclude' => 1,
                'label' => $ll . 'pages.sharing_enabled',
                'config' => [
                    'type' => 'check',
                    'default' => '1',
                ],
            ],
            'tags' => [
                'exclude' => 1,
                'label' => $ll . 'pages.tags',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectMultipleSideBySide',
                    'size' => 10,
                    'minitems' => 0,
                    'maxitems' => 9999,
                    'autoSizeMax' => 10,
                    'multiple' => 0,
                    'foreign_table' => 'tx_blog_domain_model_tag',
                    'foreign_table_where' => 'AND tx_blog_domain_model_tag.pid = ###PAGE_TSCONFIG_ID###',
                    'MM' => 'tx_blog_tag_pages_mm',
                    'enableMultiSelectFilterTextfield' => 1,
                ],

            ]
        ];

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
            'pages',
            $temporaryColumns
        );
        $GLOBALS['TCA']['pages']['columns']['categories']['config']['foreign_table_where']
            = ' AND sys_category.pid = ###PAGE_TSCONFIG_ID### '
            . $GLOBALS['TCA']['pages']['columns']['categories']['config']['foreign_table_where'];
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            'pages',
            '--div--;' . $ll . 'pages.tabs.blog, tags, comments_active, comments, sharing_enabled',
            (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST
        );
    },
    'blog',
    'pages'
);

