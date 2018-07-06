<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';
$temporaryColumns = [
    'content' => [
        'exclude' => 1,
        'label' => $ll.'sys_category.content',
        'config' => [
            'type' => 'inline',
            'allowed' => 'tt_content',
            'foreign_table' => 'tt_content',
            'foreign_sortby' => 'sorting',
            'foreign_field' => 'tx_blog_category_content',
            'minitems' => 0,
            'maxitems' => 99,
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 1,
                'levelLinksPosition' => 'bottom',
                'useSortable' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showRemovedLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1,
                'showSynchronizationLink' => 1,
                'enabledControls' => [
                    'info' => false,
                ],
            ],
            'richtextConfiguration' => 'default'
        ],
    ],
    'posts' => [
        'exclude' => 1,
        'label' => $ll.'sys_category.posts',
        'config' => [
            'type' => 'group',
            'size' => 5,
            'internal_type' => 'db',
            'allowed' => 'pages',
            'foreign_table' => 'pages',
            'MM' => 'sys_category_record_mm',
            'maxitems' => 1000
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'sys_category',
    $temporaryColumns
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    '--div--;'.$ll.'sys_category.tabs.seo, content, --div--;'.$ll.'sys_category.tabs.blog, posts'
);
