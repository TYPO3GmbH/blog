<?php
defined('TYPO3_MODE') or die();

$ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_blog_domain_model_comment',
        'label' => 'comment',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'default_sortby' => 'ORDER BY crdate DESC',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment.svg',
        'searchFields' => 'uid,comment,name,email',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,author,name,email,comment'
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
        'author' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_comment.author',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => '1',
                'maxitems' => '1',
                'minitems' => '0',
                'show_thumbs' => '0',
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                    ),
                ),
            ]
        ],
        'name' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_comment.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ]
        ],
        'email' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_comment.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'email',
            ]
        ],
        'comment' => [
            'exclude' => 0,
            'label' => $ll . 'tx_blog_domain_model_comment.comment',
            'config' => [
                'type' => 'text',
                'size' => 30,
                'eval' => '',
            ]
        ],
    ],
    'types' => [
        0 => [
            'showitem' => 'author,name,email,comment'
        ]
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => 'hidden,',
            'canNotCollapse' => true
        ],
    ]
];