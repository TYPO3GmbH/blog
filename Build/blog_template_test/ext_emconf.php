<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Blog Template Test',
    'description' => '',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'fluid_styled_content' => '*',
            'blog' => '*'
        ]
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'TYPO3 GmbH',
    'author_email' => 'info@typo3.com',
    'author_company' => 'TYPO3 GmbH',
    'version' => '1.0.0',
];
