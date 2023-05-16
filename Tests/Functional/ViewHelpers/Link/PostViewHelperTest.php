<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\ViewHelpers\Link;

use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Tests\Functional\SiteBasedTestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class PostViewHelperTest extends SiteBasedTestCase
{
    /**
     * @test
     * @dataProvider renderDataProvider
     */
    public function render(string $template, string $expected): void
    {
        $this->createTestSite();

        (new ConnectionPool())->getConnectionForTable('pages')->insert(
            'pages',
            [
                'uid' => 100,
                'pid' => self::STORAGE_UID,
                'doktype' => Constants::DOKTYPE_BLOG_POST,
                'title' => 'First blog post',
                'slug' => '/first-blog-post'
            ]
        );

        $instructions = [
            [
                'type' => 'post',
                'uid' => 100,
                'as' => 'post',
            ]
        ];

        self::assertSame(
            $expected,
            $this->renderFluidTemplateInTestSite($template, $instructions)
        );
    }

    public static function renderDataProvider(): array
    {
        return [
            'simple' => [
                '<blogvh:link.post post="{test.post}" />',
                '<a href="/first-blog-post">First blog post</a>',
            ],
            'target' => [
                '<blogvh:link.post post="{test.post}" target="_blank" />',
                '<a target="_blank" href="/first-blog-post">First blog post</a>',
            ],
            'rel' => [
                '<blogvh:link.post post="{test.post}" rel="noreferrer" />',
                '<a rel="noreferrer" href="/first-blog-post">First blog post</a>',
            ],
            'itemprop' => [
                '<blogvh:link.post post="{test.post}" itemprop="name" />',
                '<a itemprop="name" href="/first-blog-post">First blog post</a>',
            ],
            'section' => [
                '<blogvh:link.post post="{test.post}" section="demo" />',
                '<a href="/first-blog-post#demo">First blog post</a>',
            ],
            'createAbsoluteUri' => [
                '<blogvh:link.post post="{test.post}" createAbsoluteUri="1" />',
                '<a href="https://test.typo3.com/first-blog-post">First blog post</a>',
            ],
            'returnUri' => [
                '<blogvh:link.post post="{test.post}" returnUri="1" />',
                '/first-blog-post',
            ],
            'content' => [
                '<blogvh:link.post post="{test.post}">Hello</blogvh:link.post>',
                '<a href="/first-blog-post">Hello</a>',
            ],
            'class' => [
                '<blogvh:link.post post="{test.post}" class="class" />',
                '<a class="class" href="/first-blog-post">First blog post</a>',
            ],
        ];
    }
}
