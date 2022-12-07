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

return [
    'ctrl' => [
        'title' => $ll . 'tx_blog_domain_model_comment',
        'label' => 'name',
        'label_alt' => 'crdate',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate DESC',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_classes' => [
            'default' => 'record-blog-comment'
        ],
        'searchFields' => 'uid,comment,name,email',
        'security' => [
            'ignorePageTypeRestriction' => true,
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
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        // author not implemented yet
        'author' => [
            'label' => $ll . 'tx_blog_domain_model_comment.author',
            'config' => [
                'type' => 'group',
                'allowed' => 'fe_users',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => '0',
                'fieldWizard' => [
                    'recordsOverview' => [
                        'disabled' => true
                    ]
                ]
            ],
        ],
        'name' => [
            'label' => $ll . 'tx_blog_domain_model_comment.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'url' => [
            'label' => $ll . 'tx_blog_domain_model_comment.url',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'www',
            ],
        ],
        'email' => [
            'label' => $ll . 'tx_blog_domain_model_comment.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'email',
            ],
        ],
        'comment' => [
            'label' => $ll . 'tx_blog_domain_model_comment.comment',
            'config' => [
                'type' => 'text',
                'size' => 30,
                'eval' => '',
            ],
        ],
        'post_language_id' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'status' => [
            'label' => $ll . 'tx_blog_domain_model_comment.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [$ll . 'tx_blog_domain_model_comment.status.pending', \T3G\AgencyPack\Blog\Domain\Model\Comment::STATUS_PENDING],
                    [$ll . 'tx_blog_domain_model_comment.status.approved', \T3G\AgencyPack\Blog\Domain\Model\Comment::STATUS_APPROVED],
                    [$ll . 'tx_blog_domain_model_comment.status.declined', \T3G\AgencyPack\Blog\Domain\Model\Comment::STATUS_DECLINED],
                    [$ll . 'tx_blog_domain_model_comment.status.deleted', \T3G\AgencyPack\Blog\Domain\Model\Comment::STATUS_DELETED],
                ],
            ],
        ],
        'parentid' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'pages',
                'foreign_table_where' => ' AND doktype = ' . \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST,
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'parenttable' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hp' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
    'types' => [
        0 => [
            'showitem' => 'post_language_id,status,name,url,email,comment,post',
        ],
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => 'hidden,',
            'canNotCollapse' => true,
        ],
    ],
];
