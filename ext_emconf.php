<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Blog Extension',
    'description' => 'This blog extension use TYPO3s core concepts and elements to provide a full-blown blog that users of TYPO3 can instantly understand and use.',
    'category' => 'fe',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'TYPO3 GmbH',
    'author_email' => 'info@typo3.com',
    'version' => '1.3.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
