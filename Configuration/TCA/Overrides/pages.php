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

$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod.xlf:blog-folder',
    1 => 'blog',
    2 => 'apps-pagetree-folder-contains-blog',
];

$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-blog'] = 'apps-pagetree-folder-contains-blog';

call_user_func(function () {
    $blogDocType = \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST;

    // Add new page type as possible select item:
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'pages',
        'doktype',
        [
            'LLL:EXT:blog/Resources/Private/Language/locallang_tca.xlf:pages.doktype.blog-post',
            $blogDocType,
            'apps-pagetree-blog-post',
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
                'multiple' => 1,
                'foreign_table' => 'tx_blog_domain_model_author',
                'MM' => 'tx_blog_post_author_mm',
                'minitems' => 0,
                'maxitems' => 99999,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
        'blog',
        'Configuration/PageTS/SocialImageWizard.tsconfig',
        'Blog: SocialImageWizard'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'pages',
        $temporaryColumns
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
        --palette--;' . $ll . 'pages.palettes.publish_date;publish_date, archive_date, tags, authors, comments_active, comments, sharing_enabled',
        (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST
    );

    // Register Social Image Wizard
    /** @noinspection UnsupportedStringOffsetOperationsInspection */
    $GLOBALS['TCA']['pages']['ctrl']['container']['inline']['fieldWizard']['BlogSocialImageWizard']['renderType'] = 'BlogSocialImageWizard';
});
