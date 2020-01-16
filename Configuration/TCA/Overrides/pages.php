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

// Add folder configuration
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => $ll . 'blog-folder',
    1 => 'blog',
    2 => 'record-folder-contains-blog',
];
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-blog'] = 'record-folder-contains-blog';

// Add new page type as possible select item:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'pages',
    'doktype',
    [
        'LLL:EXT:blog/Resources/Private/Language/locallang_tca.xlf:pages.doktype.blog-post',
        (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST,
        'record-blog-post',
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
                (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST => 'record-blog-post',
            ],
        ],
        'types' => [
            (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST => $GLOBALS['TCA']['pages']['types'][\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT],
        ],
    ]
);

// Register fields
$GLOBALS['TCA']['pages']['columns'] = array_replace_recursive(
    $GLOBALS['TCA']['pages']['columns'],
    [
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
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
        'crdate_month' => [
            'exclude' => 1,
            'label' => $ll . 'pages.crdate_month',
            'config' => [
                'type' => 'input',
                'size' => '13',
                'eval' => 'num',
                'default' => '0',
                'readOnly' => true,
            ],
        ],
        'crdate_year' => [
            'exclude' => 1,
            'label' => $ll . 'pages.crdate_year',
            'config' => [
                'type' => 'input',
                'size' => '13',
                'eval' => 'num',
                'default' => '0',
                'readOnly' => true,
            ],
        ],
        'archive_date' => [
            'exclude' => 1,
            'label' => $ll . 'pages.archive_date',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => '13',
                'eval' => 'datetime',
                'default' => '0',
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'publish_date' => [
            'exclude' => 1,
            'label' => $ll . 'pages.publish_date',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => '13',
                'eval' => 'datetime',
                'default' => '0',
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
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
                'foreign_table_where' => 'AND tx_blog_domain_model_tag.sys_language_uid IN (0,-1) AND tx_blog_domain_model_tag.pid = ###PAGE_TSCONFIG_ID### ORDER BY tx_blog_domain_model_tag.title ASC',
                'MM' => 'tx_blog_tag_pages_mm',
                'enableMultiSelectFilterTextfield' => 1,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'authors' => [
            'exclude' => 1,
            'label' => $ll . 'pages.authors',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'multiple' => 0,
                'foreign_table' => 'tx_blog_domain_model_author',
                'MM' => 'tx_blog_post_author_mm',
                'minitems' => 0,
                'maxitems' => 99999,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'featured_image' => [
            'exclude' => true,
            'label' => $ll . 'pages.featured_image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'featured_image',
                [
                    'minitems' => 0,
                    'maxitems' => 1,
                    'behaviour' => [
                        'allowLanguageSynchronization' => true
                    ]
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
    ]
);

/** @noinspection UnsupportedStringOffsetOperationsInspection */
$GLOBALS['TCA']['pages']['types'][\T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST]['columnsOverrides'] = [
    'categories' => [
        'config' => [
            'foreign_table_where' => ' AND sys_category.pid = ###PAGE_TSCONFIG_ID### ' .
                $GLOBALS['TCA']['pages']['columns']['categories']['config']['foreign_table_where']
        ]
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'publish_date', 'publish_date, crdate_month, crdate_year');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;' . $ll . 'pages.tabs.blog,
    --palette--;' . $ll . 'pages.palettes.publish_date;publish_date, featured_image, archive_date, tags, authors, comments_active, comments',
    (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST
);
