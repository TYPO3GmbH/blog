<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Hooks;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * AutoConfiguration-Hook for RealURL.
 */
class RealUrlAutoConfiguration
{
    /**
     * Generates additional RealURL configuration and merges it with provided configuration.
     *
     * @param array $params Default configuration
     * @return array Updated configuration
     */
    public function addBlogConfiguration($params): array
    {
        ArrayUtility::mergeRecursiveWithOverrule($params['config'], [
            'fileName' => [
                'index' => [
                    'posts.xml' => [
                        'keyValues' => [
                            'type' => 200
                        ],
                    ],
                    'categories.xml' => [
                        'keyValues' => [
                            'type' => 210
                        ],
                    ],
                    'authors.xml' => [
                        'keyValues' => [
                            'type' => 250
                        ]
                    ]
                ]
            ],
            'postVarSets' => [
                '_DEFAULT' => [
                    'tx_blog_feed' => [
                        [
                            'GETvar' => 'tx_blog_posts[controller]',
                            'valueMap' => [
                                'posts' => 'Post'
                            ]
                        ],
                        [
                            'GETvar' => 'tx_blog_posts[action]',
                            'valueMap' => [
                                'recent' => 'listRecentPosts'
                            ]
                        ],
                        [
                            'GETvar' => 'tx_blog_posts[format]'
                        ]
                    ]
                ]
            ],
            'fixedPostVars' => [
                'tx_blog_tag' => [
                    [
                        'GETvar' => 'tx_blog_tag[tag]',
                        'lookUpTable' => [
                            'table' => 'tx_blog_domain_model_tag',
                            'id_field' => 'uid',
                            'alias_field' => 'title',
                            'useUniqueCache' => 1,
                            'useUniqueCache_conf' => [
                                'strtolower' => 1,
                                'spaceCharacter' => '-',
                            ],
                            'languageGetVar' => 'L',
                            'languageExceptionUids' => '',
                            'languageField' => 'sys_language_uid',
                            'transOrigPointerField' => 'l18n_parent',
                            'noMatch' => 'bypass',
                        ],
                    ],
                ],
                'tx_blog_category' => [
                    [
                        'GETvar' => 'tx_blog_category[category]',
                        'lookUpTable' => [
                            'table' => 'sys_category',
                            'id_field' => 'uid',
                            'alias_field' => 'title',
                            'useUniqueCache' => 1,
                            'useUniqueCache_conf' => [
                                'strtolower' => 1,
                                'spaceCharacter' => '-',
                            ],
                            'languageGetVar' => 'L',
                            'languageExceptionUids' => '',
                            'languageField' => 'sys_language_uid',
                            'transOrigPointerField' => 'l10n_parent',
                            'noMatch' => 'bypass',
                        ],
                    ],
                ],
                'tx_blog_author' => [
                    [
                        'GETvar' => 'tx_blog_authorposts[author]',
                        'lookUpTable' => [
                            'table' => 'tx_blog_domain_model_author',
                            'id_field' => 'uid',
                            'alias_field' => 'name',
                            'useUniqueCache' => 1,
                            'useUniqueCache_conf' => [
                                'strtolower' => 1,
                                'spaceCharacter' => '-',
                            ],
                            'noMatch' => 'bypass',
                        ],
                    ],
                ],
                'tx_blog_archive' => [
                    [
                        'GETvar' => 'tx_blog_archive[year]',
                    ],
                    [
                        'GETvar' => 'tx_blog_archive[month]',
                        'valueMap' => [
                            'january' => '1',
                            'february' => '2',
                            'march' => '3',
                            'april' => '4',
                            'may' => '5',
                            'june' => '6',
                            'july' => '7',
                            'august' => '8',
                            'september' => '9',
                            'october' => '10',
                            'november' => '11',
                            'december' => '12',
                        ],
                    ],
                ],
            ],
        ]);

        return $params['config'];
    }
}
