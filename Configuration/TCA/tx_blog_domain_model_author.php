<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll.'tx_blog_domain_model_author',
        'label' => 'name',
        'label_alt' => 'sys_language_uid',
        // Display Language after Label
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
        'iconfile' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-author.svg',
        'searchFields' => 'uid,name,title',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,name,title,website,email,location,twitter,googleplus,linkedin,xing,profile,bio',
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
        'name' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required',
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'website' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.website',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'domainname',
            ],
        ],
        'email' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,email',
            ],
        ],
        'location' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.location',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'twitter' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.twitter',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'googleplus' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.googleplus',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'linkedin' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.linkedin',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'xing' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.xing',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'profile' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.profile',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'bio' => [
            'exclude' => 0,
            'label' => $ll.'tx_blog_domain_model_author.bio',
            'config' => [
                'type' => 'text',
                'eval' => '',
            ],
        ],
    ],
    'types' => [
        0 => [
            'showitem' => 'name,title,website,email,location,twitter,googleplus,linkedin,xing,profile,bio',
        ],
    ],
    'palettes' => [
    ],
];
