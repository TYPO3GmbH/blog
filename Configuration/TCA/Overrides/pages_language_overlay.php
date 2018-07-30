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

call_user_func(
    function ($extKey, $table) {
        $blogDocType = \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST;

        // Add new page type as possible select item:
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'doktype',
            [
                'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_tca.xlf:pages.doktype.blog-post',
                $blogDocType,
                'apps-pagetree-blog-post',
            ],
            '1',
            'after'
        );

        // Add icon for new page type:
        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
            $GLOBALS['TCA'][$table],
            [
                'ctrl' => [
                    'typeicon_classes' => [
                        $blogDocType => 'apps-pagetree-blog-post',
                    ],
                ],
                'types' => [
                    (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST => $GLOBALS['TCA'][$table]['types'][\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT],
                ],
            ]
        );

        $ll = 'LLL:EXT:blog/Resources/Private/Language/locallang_db.xlf:';
        $temporaryColumns = [
            'crdate' => [
                'exclude' => 1,
                'label' => $ll . 'pages.crdate',
                'config' => [
                    'type' => 'input',
                    'size' => '13',
                    'eval' => 'datetime',
                    'default' => '0',
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
        ];

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
            $table,
            $temporaryColumns
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            $table,
            '--div--;' . $ll . 'pages.tabs.blog, crdate, crdate_month, crdate_year',
            (string) \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST
        );
    },
    'blog',
    'pages_language_overlay'
);
