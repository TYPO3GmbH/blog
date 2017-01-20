<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Blog Extension',
    'description' => 'Blogging with TYPO3',
    'category' => 'fe',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'TYPO3 Core Team',
    'author_email' => 'typo3cms@typo3.org',
    'version' => '1.2.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
