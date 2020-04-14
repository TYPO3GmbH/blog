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

$ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';

// Add category types
$GLOBALS['TCA']['sys_category']['ctrl']['type'] = 'record_type';
$GLOBALS['TCA']['sys_category']['ctrl']['typeicon_column'] = 'record_type';
$GLOBALS['TCA']['sys_category']['ctrl']['typeicon_classes'][(string) \T3G\AgencyPack\Blog\Constants::CATEGORY_TYPE_BLOG] = 'record-blog-category';
$GLOBALS['TCA']['sys_category']['columns']['record_type'] = [
    'label' => $ll . 'sys_category.record_type',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
            [
                'LLL:EXT:blog/Resources/Private/Language/locallang_tca.xlf:sys_category.record_type.default',
                (string) \T3G\AgencyPack\Blog\Constants::CATEGORY_TYPE_DEFAULT,
                $GLOBALS['TCA']['sys_category']['ctrl']['typeicon_classes']['default']
            ],
            [
                'LLL:EXT:blog/Resources/Private/Language/locallang_tca.xlf:sys_category.record_type.blog',
                (string) \T3G\AgencyPack\Blog\Constants::CATEGORY_TYPE_BLOG,
                'record-blog-category'
            ]
        ],
        'default' => (string) \T3G\AgencyPack\Blog\Constants::CATEGORY_TYPE_DEFAULT
    ]
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    'record_type',
    '',
    'before:title'
);
$GLOBALS['TCA']['sys_category']['types'][(string) \T3G\AgencyPack\Blog\Constants::CATEGORY_TYPE_BLOG] =
    $GLOBALS['TCA']['sys_category']['types'][(string) \T3G\AgencyPack\Blog\Constants::CATEGORY_TYPE_DEFAULT];

// Limit parent categories to blog types
$GLOBALS['TCA']['sys_category']['types'][\T3G\AgencyPack\Blog\Constants::CATEGORY_TYPE_BLOG]['columnsOverrides'] = [
    'parent' => [
        'config' => [
            'foreign_table_where' => '' .
                ' AND sys_category.record_type = ' . (string) \T3G\AgencyPack\Blog\Constants::CATEGORY_TYPE_BLOG . ' ' .
                ' AND sys_category.pid = ###CURRENT_PID### ' .
                $GLOBALS['TCA']['pages']['columns']['categories']['config']['foreign_table_where']
        ]
    ]
];

// Register fields
$GLOBALS['TCA']['sys_category']['columns'] = array_replace_recursive(
    $GLOBALS['TCA']['sys_category']['columns'],
    [
        'slug' => [
            'label' => $ll . 'sys_category.slug',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['title'],
                    'replacements' => [
                        '/' => ''
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => ''
            ]
        ],
        'content' => [
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
                'richtextConfiguration' => 'default'
            ],
        ],
        'posts' => [
            'label' => $ll . 'sys_category.posts',
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
    ]
);

// Add slug field to all types
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    'slug',
    '',
    'after:title'
);

// Add blog specific fields to blog categories
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    '
        --div--;' . $ll . 'sys_category.tabs.seo,
            content,
        --div--;' . $ll . 'sys_category.tabs.blog,
            posts
    ',
    (string) \T3G\AgencyPack\Blog\Constants::CATEGORY_TYPE_BLOG
);
