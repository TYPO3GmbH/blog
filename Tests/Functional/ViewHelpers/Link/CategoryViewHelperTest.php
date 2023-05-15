<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\ViewHelpers;

use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Tests\Functional\SiteBasedTestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class CategoryViewHelperTest extends SiteBasedTestCase
{
    /**
     * @test
     * @dataProvider renderDataProvider
     */
    public function render(string $template, string $expected): void
    {
        $this->createTestSite();

        (new ConnectionPool())->getConnectionForTable('pages')->insert(
            'sys_category',
            [
                'uid' => 100,
                'pid' => self::STORAGE_PID,
                'record_type' => Constants::CATEGORY_TYPE_BLOG,
                'title' => 'Blog',
                'slug' => 'blog'
            ]
        );

        $instructions = [
            [
                'type' => 'category',
                'uid' => 100,
                'as' => 'category',
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
                '<blogvh:link.category category="{test.category}" />',
                '<a href="/category/category/blog">Blog</a>',
            ],
            'target' => [
                '<blogvh:link.category category="{test.category}" target="_blank" />',
                '<a target="_blank" href="/category/category/blog">Blog</a>',
            ],
            'rel' => [
                '<blogvh:link.category category="{test.category}" rel="noreferrer" />',
                '<a rel="noreferrer" href="/category/category/blog">Blog</a>',
            ],
            'rss' => [
                '<blogvh:link.category category="{test.category}" rss="true" />',
                '<a href="/category/category/blog/blog.category.xml">Blog</a>',
            ],
            'content' => [
                '<blogvh:link.category category="{test.category}">Hello</blogvh:link.category>',
                '<a href="/category/category/blog">Hello</a>',
            ],
            'class' => [
                '<blogvh:link.category category="{test.category}" class="class" />',
                '<a class="class" href="/category/category/blog">Blog</a>',
            ],
        ];
    }
}
