<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'blog_BlogBlog' => [
        'position' => ['after' => 'web'],
        'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog.xlf',
        'iconIdentifier' => 'module-blog',
    ],
    'blog_BlogBlogPosts' => [
        'parent' => 'blog_BlogBlog',
        'access' => 'user',
        'path' => '/module/blog/posts',
        'iconIdentifier' => 'module-blog-posts',
        'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_posts.xlf',
        'extensionName' => 'Blog',
        'controllerActions' => [
            \T3G\AgencyPack\Blog\Controller\BackendController::class => [
                'posts',
            ],
        ],
    ],
    'blog_BlogBlogComments' => [
        'parent' => 'blog_BlogBlog',
        'access' => 'user',
        'path' => '/module/blog/comments',
        'iconIdentifier' => 'module-blog-comments',
        'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_comments.xlf',
        'extensionName' => 'Blog',
        'controllerActions' => [
            \T3G\AgencyPack\Blog\Controller\BackendController::class => [
                'comments',
                'updateCommentStatus'
            ],
        ],
    ],
    'blog_BlogBlogSetup' => [
        'parent' => 'blog_BlogBlog',
        'access' => 'admin',
        'path' => '/module/blog/setup',
        'iconIdentifier' => 'module-blog-setup',
        'labels' => 'LLL:EXT:blog/Resources/Private/Language/locallang_mod_blog_setup.xlf',
        'extensionName' => 'Blog',
        'controllerActions' => [
            \T3G\AgencyPack\Blog\Controller\BackendController::class => [
                'setupWizard',
                'createBlog',
            ],
        ],
    ],
];
