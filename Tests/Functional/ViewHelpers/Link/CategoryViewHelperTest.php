<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\ViewHelpers\Link;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Tests\Functional\SiteBasedTestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class CategoryViewHelperTest extends SiteBasedTestCase
{
    private const CATEGORY_UID = 100;
    private const CATEGORY_PAGE_UID = 9;

    #[Test]
    #[DataProvider('renderDataProvider')]
    public function render(string $template, string $expected): void
    {
        $this->createTestSite();
        $this->createCategory();

        self::assertSame(
            $expected,
            $this->renderFluidTemplateInTestSite($template, self::categoryInstructions())
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

    #[Test]
    public function renderLinksToThePageAssignedToTheCategory(): void
    {
        $this->createTestSite();
        $this->createCategoryPage();
        $this->createCategory(self::CATEGORY_PAGE_UID);

        self::assertSame(
            '<a href="/category-page">Blog</a>',
            $this->renderFluidTemplateInTestSite(
                '<blogvh:link.category category="{test.category}" />',
                self::categoryInstructions()
            )
        );
    }

    #[Test]
    public function renderLinksToTheGeneratedCategoryPageForFeeds(): void
    {
        $this->createTestSite();
        $this->createCategoryPage();
        $this->createCategory(self::CATEGORY_PAGE_UID);

        self::assertSame(
            '<a href="/category/category/blog/blog.category.xml">Blog</a>',
            $this->renderFluidTemplateInTestSite(
                '<blogvh:link.category category="{test.category}" rss="true" />',
                self::categoryInstructions()
            )
        );
    }

    private function createCategory(int $targetPageUid = 0): void
    {
        (new ConnectionPool())->getConnectionForTable('sys_category')->insert(
            'sys_category',
            [
                'uid' => self::CATEGORY_UID,
                'pid' => self::STORAGE_UID,
                'record_type' => Constants::CATEGORY_TYPE_BLOG,
                'title' => 'Blog',
                'slug' => 'blog',
                'blog_target_page' => $targetPageUid,
            ]
        );
    }

    private function createCategoryPage(): void
    {
        (new ConnectionPool())->getConnectionForTable('pages')->insert(
            'pages',
            [
                'uid' => self::CATEGORY_PAGE_UID,
                'pid' => self::ROOT_UID,
                'doktype' => 1,
                'title' => 'Category Page',
                'slug' => '/category-page',
            ]
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function categoryInstructions(): array
    {
        return [
            [
                'type' => 'category',
                'uid' => self::CATEGORY_UID,
                'as' => 'category',
            ]
        ];
    }
}
