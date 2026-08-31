<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\Middleware;

use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Tests\Functional\SiteBasedTestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;

final class CategoryPageRedirectTest extends SiteBasedTestCase
{
    private const CATEGORY_UID = 100;
    private const CATEGORY_PAGE_UID = 9;

    #[Test]
    public function categoryUrlRedirectsToTheAssignedPage(): void
    {
        $this->createTestSite();
        $this->createCategoryPage();
        $this->createCategory(self::CATEGORY_PAGE_UID);

        $response = $this->executeFrontendSubRequest(
            new InternalRequest(self::BASE_URL . 'category/category/blog')
        );

        self::assertSame(301, $response->getStatusCode());
        self::assertSame(self::BASE_URL . 'category-page', $response->getHeaderLine('location'));
    }

    #[Test]
    public function paginatedCategoryUrlRedirectsToTheAssignedPage(): void
    {
        $this->createTestSite();
        $this->createCategoryPage();
        $this->createCategory(self::CATEGORY_PAGE_UID);

        $response = $this->executeFrontendSubRequest(
            new InternalRequest(self::BASE_URL . 'category/category/blog/page-2')
        );

        self::assertSame(301, $response->getStatusCode());
        self::assertSame(self::BASE_URL . 'category-page', $response->getHeaderLine('location'));
    }

    #[Test]
    public function categoryUrlIsNotRedirectedWithoutAnAssignedPage(): void
    {
        $this->createTestSite();
        $this->createCategoryPage();
        $this->createCategory();

        $response = $this->executeFrontendSubRequest(
            new InternalRequest(self::BASE_URL . 'category/category/blog')
        );

        self::assertSame(200, $response->getStatusCode());
    }

    #[Test]
    public function categoryFeedIsNotRedirected(): void
    {
        $this->createTestSite();
        $this->createCategoryPage();
        $this->createCategory(self::CATEGORY_PAGE_UID);

        $response = $this->executeFrontendSubRequest(
            new InternalRequest(self::BASE_URL . 'category/category/blog/blog.category.xml')
        );

        self::assertSame(200, $response->getStatusCode());
    }

    #[Test]
    public function categoryOverviewRedirectsToTheConfiguredPage(): void
    {
        $this->createTestSite(['categoryOverviewUid' => self::CATEGORY_PAGE_UID]);
        $this->createCategoryPage();
        $this->createCategory();

        $response = $this->executeFrontendSubRequest(
            new InternalRequest(self::BASE_URL . 'category')
        );

        self::assertSame(301, $response->getStatusCode());
        self::assertSame(self::BASE_URL . 'category-page', $response->getHeaderLine('location'));
    }

    #[Test]
    public function categoryOverviewIsNotRedirectedWithoutConfiguredPage(): void
    {
        $this->createTestSite();
        $this->createCategoryPage();
        $this->createCategory();

        $response = $this->executeFrontendSubRequest(
            new InternalRequest(self::BASE_URL . 'category')
        );

        self::assertSame(200, $response->getStatusCode());
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
}
