<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

if (!defined('TYPO3')) {
    die('Access denied.');
}

$ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';

// Add folder configuration
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    'label' => $ll . 'blog-folder',
    'value' => 'blog',
    'icon' => 'record-folder-contains-blog',
];
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-blog'] = 'record-folder-contains-blog';

// Add doctype group label
$GLOBALS['TCA']['pages']['columns']['doktype']['config']['itemGroups']['blog'] = 'Blog';

// Add new page types as possible select item:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'pages',
    'doktype',
    [
        'label' => 'LLL:EXT:blog/Resources/Private/Language/locallang_tca.xlf:pages.doktype.blog-post',
        'value' => (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST,
        'icon' => 'record-blog-post',
        'group' => 'blog',
    ],
    '1',
    'after'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'pages',
    'doktype',
    [
        'label' => 'LLL:EXT:blog/Resources/Private/Language/locallang_tca.xlf:pages.doktype.blog-page',
        'value' => (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_PAGE,
        'icon' => 'record-blog-page',
        'group' => 'blog',
    ],
    (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST,
    'after'
);

// Add icon for new page types:
\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
    $GLOBALS['TCA']['pages'],
    [
        'ctrl' => [
            'typeicon_classes' => [
                (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_PAGE => 'record-blog-page',
                (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_PAGE . '-root' => 'record-blog-page-root',
                (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST => 'record-blog-post',
            ],
        ],
        'types' => [
            (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST => $GLOBALS['TCA']['pages']['types'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_DEFAULT],
        ],
    ]
);
\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
    $GLOBALS['TCA']['pages'],
    [
        'ctrl' => [
            'typeicon_classes' => [
                (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_PAGE => 'record-blog-page',
            ],
        ],
        'types' => [
            (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_PAGE => $GLOBALS['TCA']['pages']['types'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_DEFAULT],
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
            'label' => $ll . 'pages.comments_active',
            'config' => [
                'type' => 'check',
                'default' => '1',
            ],
        ],
        'comments' => [
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
            'label' => $ll . 'pages.archive_date',
            'config' => [
                'type' => 'datetime',
                'size' => '13',
                'default' => '0',
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'publish_date' => [
            'label' => $ll . 'pages.publish_date',
            'config' => [
                'type' => 'datetime',
                'size' => '13',
                'default' => '0',
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'tags' => [
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
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'authors' => [
            'label' => $ll . 'pages.authors',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'multiple' => 0,
                'foreign_table' => 'tx_blog_domain_model_author',
                'foreign_table_where' => 'AND tx_blog_domain_model_author.sys_language_uid IN (0,-1) AND tx_blog_domain_model_author.pid = ###PAGE_TSCONFIG_ID### ORDER BY tx_blog_domain_model_author.name ASC',
                'MM' => 'tx_blog_post_author_mm',
                'minitems' => 0,
                'maxitems' => 99999,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'featured_image' => [
            'label' => $ll . 'pages.featured_image',
            'config' => [
                'type' => 'file',
                'minitems' => 0,
                'maxitems' => 1,
                'allowed' => 'common-image-types',
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'categories' => [
            'config' => [
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ]
        ]
    ]
);

$GLOBALS['TCA']['pages']['types'][\T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST]['columnsOverrides'] = [
    'categories' => [
        'config' => [
            'foreign_table_where' => 'AND sys_category.sys_language_uid IN (0,-1) AND sys_category.pid = ###PAGE_TSCONFIG_ID###',
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
