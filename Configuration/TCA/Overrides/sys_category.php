<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';
$temporaryColumns = [
    'content' => [
        'exclude' => 1,
        'label' => $ll . 'sys_category.content',
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
        ],
        'defaultExtras' => 'richtext:rte_transform',
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'sys_category',
    $temporaryColumns
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    '--div--;' . $ll . 'sys_category.tabs.seo, content'
);
