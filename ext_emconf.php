<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Blog Extension',
    'description' => 'This blog extension uses TYPO3s core concepts and elements to provide a full-blown blog that users of TYPO3 can instantly understand and use.',
    'category' => 'fe',
    'state' => 'stable',
    'author' => 'TYPO3 GmbH',
    'author_email' => 'info@typo3.com',
    'version' => '13.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'form' => '13.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
