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

$ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf' . ':';

return [
    'ctrl' => [
        'title' => $ll . 'tx_blog_domain_model_author',
        'label' => 'name',
        'label_alt_force' => 0,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'default_sortby' => 'ORDER BY title',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_classes' => [
            'default' => 'record-blog-author'
        ],
        'searchFields' => 'uid,name,title',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
    ],
    'interface' => [
        'showRecordFieldList' => '
            hidden,
            name,
            slug,
            image,
            title,
            website,
            email,
            location,
            twitter,
            linkedin,
            xing,
            profile,
            bio,
            posts
        ',
    ],
    'palettes' => [
        'palette_access' => [
            'showitem' => 'hidden'
        ],
        'palette_personal' => [
            'showitem' => 'name, title'
        ],
        'palette_contact' => [
            'showitem' => 'website, email'
        ],
    ],
    'columns' => [
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'name' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required',
            ],
        ],
        'slug' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.slug',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['name'],
                    'replacements' => [
                        '/' => ''
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => ''
            ]
        ],
        'avatar_provider' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.avatar_provider',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Please choose one avatar provider', '--div--'],
                    ['Gravatar', \T3G\AgencyPack\Blog\AvatarProvider\GravatarProvider::class],
                    ['Image', \T3G\AgencyPack\Blog\AvatarProvider\ImageProvider::class],
                ],
            ],
        ],
        'image' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.image',
            'displayCond' => 'FIELD:avatar_provider:=:T3G\AgencyPack\Blog\AvatarProvider\ImageProvider',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    crop,
                                    --palette--;;filePalette
                                '
                            ],
                        ],
                    ],
                    'minitems' => 0,
                    'maxitems' => 1,
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'title' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'website' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.website',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'domainname',
            ],
        ],
        'email' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,email',
            ],
        ],
        'location' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.location',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'twitter' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.twitter',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'linkedin' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.linkedin',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'xing' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.xing',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'profile' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.profile',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'bio' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_author.bio',
            'config' => [
                'type' => 'text',
                'eval' => '',
            ],
        ],
        'posts' => [
            'label' => $ll . 'tx_blog_domain_model_author.posts',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'multiple' => 0,
                'foreign_table' => 'pages',
                'foreign_table_where' => 'AND {#pages}.{#doktype}=' . \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST . ' AND {#pages}.{#sys_language_uid} IN (-1,0)',
                'MM' => 'tx_blog_post_author_mm',
                'MM_opposite_field' => 'authors',
                'minitems' => 0,
                'maxitems' => 99999,
            ],
        ],
        'details_page' => [
            'exclude' => 1,
            'label' => $ll . 'tx_blog_domain_model_author.details_page',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
                'default' => 0
            ]
        ]
    ],
    'sys_language_uid' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
        'config' => [
            'type' => 'select',
            'default' => 0,
            'renderType' => 'selectSingle',
            'foreign_table' => 'sys_language',
            'foreign_table_where' => 'ORDER BY sys_language.title',
            'items' => [
                ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1],
                ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0],
            ],
        ],
    ],
    'l18n_parent' => [
        'displayCond' => 'FIELD:sys_language_uid:>:0',
        'exclude' => 1,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['', 0],
            ],
            'foreign_table' => 'tx_blog_domain_model_author',
            'foreign_table_where' => 'AND tx_blog_domain_model_author.pid=###CURRENT_PID### AND tx_blog_domain_model_author.sys_language_uid IN (-1,0)',
        ],
    ],
    'l18n_diffsource' => [
        'config' => [
            'type' => 'passthrough',
        ],
    ],
    'types' => [
        0 => [
            'showitem' => '
                --div--;' . $ll . 'tx_blog_domain_model_author.tab_profile,
                    --palette--;' . $ll . 'tx_blog_domain_model_author.palette_personal;palette_personal,
                    slug,
                    location,
                    avatar_provider,
                    image,
                    bio,
                    --palette--;' . $ll . 'tx_blog_domain_model_author.palette_contact;palette_contact,
                --div--;' . $ll . 'tx_blog_domain_model_author.tab_social_media,
                    twitter,
                    linkedin,
                    xing,
                    profile,
                --div--;' . $ll . 'tx_blog_domain_model_author.tab_blog,
                    posts,
                    details_page,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;palette_access
            ',
        ],
    ],
];
