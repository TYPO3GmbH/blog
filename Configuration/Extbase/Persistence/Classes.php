<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    \T3G\AgencyPack\Blog\Domain\Model\Content::class => [
        'tableName' => 'tt_content',
    ],
    \T3G\AgencyPack\Blog\Domain\Model\Post::class => [
        'tableName' => 'pages',
    ],
    \T3G\AgencyPack\Blog\Domain\Model\Category::class => [
        'tableName' => 'sys_category',
    ],
    \T3G\AgencyPack\Blog\Domain\Model\FrontendUser::class => [
        'tableName' => 'fe_users',
    ],
    \T3G\AgencyPack\Blog\Domain\Model\Comment::class => [
        'tableName' => 'tx_blog_domain_model_comment',
        'properties' => [
            'post' => [
                'fieldName' => 'parentid'
            ],
        ],
    ],
    \T3G\AgencyPack\Blog\Domain\Model\Tag::class => [
        'tableName' => 'tx_blog_domain_model_tag',
    ],
    \T3G\AgencyPack\Blog\Domain\Model\Author::class => [
        'tableName' => 'tx_blog_domain_model_author',
    ],
];
