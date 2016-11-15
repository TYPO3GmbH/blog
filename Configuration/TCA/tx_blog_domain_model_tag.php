<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_blog_domain_model_tag',
        'label' => 'title',
        'label_alt'                => 'sys_language_uid',
        // Display Language after Label
        'label_alt_force'          => 0,
        'languageField'            => 'sys_language_uid',
        'transOrigPointerField'    => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'default_sortby' => 'ORDER BY title',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-tag.svg',
        'searchFields' => 'uid,title',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,title,sys_language_uid,l18n_parent,l18n_diffsource',
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
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_tag.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,trim',
            ],
        ],
        'description' => [
            'exclude' => 1,
            'label' => $ll . 'tx_blog_domain_model_tag.description',
            'config' => [
                'type' => 'text',
            ],
        ],
        'content' => [
            'exclude' => 1,
            'label' => $ll . 'tx_blog_domain_model_tag.content',
            'config' => [
                'type' => 'inline',
                'allowed' => 'tt_content',
                'foreign_table' => 'tt_content',
                'foreign_sortby' => 'sorting',
                'foreign_field' => 'tx_blog_tag_content',
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
        'post' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'sys_language_uid' => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config'  => [
                'type'                => 'select',
                'foreign_table'       => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items'               => [
                    ['LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.php:LGL.default_value', 0]
                ]
            ]
        ],
        'l18n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => [
                'type'    => 'select',
                'items'   => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_blog_domain_model_tag',
                'foreign_table_where' => 'AND tx_blog_domain_model_tag.pid=###CURRENT_PID### AND tx_blog_domain_model_tag.sys_language_uid IN (-1,0)',
            ]
        ],
        'l18n_diffsource' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
    ],
    'types' => [
        0 => [
            'showitem' => 'title, --palette--;;paletteCore,
            --div--;' . $ll . 'tx_blog_domain_model_tag.tabs.seo, description, content',
        ],
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => 'hidden,sys_language_uid,l18n_parent,l18n_diffsource',
            'canNotCollapse' => true,
        ],
    ],
];
