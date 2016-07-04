<?php
defined('TYPO3_MODE') or die();

$ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_blog_domain_model_tag',
        'label' => 'title',
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
        'showRecordFieldList' => 'hidden,title'
    ],
    'columns' => [
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ],
        'title' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_tag.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,unique,trim',
            ]
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
                    ]
                ]
            ],
            'defaultExtras' => 'richtext:rte_transform',
        ],
    ],
    'types' => [
        0 => [
            'showitem' => 'title, --palette--;;paletteCore,
            --div--;' . $ll . 'tx_blog_domain_model_tag.tabs.seo, description, content'
        ]
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => 'hidden,',
            'canNotCollapse' => true
        ],
    ]
];
