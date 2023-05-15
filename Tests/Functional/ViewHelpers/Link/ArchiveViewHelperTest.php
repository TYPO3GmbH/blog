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

final class ArchiveViewHelperTest extends SiteBasedTestCase
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
                'pid' => self::STORAGE_PID,
                'doktype' => Constants::DOKTYPE_BLOG_POST,
                'crdate_year' => 2023,
                'crdate_month' => 5,
                'title' => 'First blog post',
                'slug' => '/first-blog-post'
            ]
        );

        self::assertSame(
            $expected,
            $this->renderFluidTemplateInTestSite($template)
        );
    }

    public static function renderDataProvider(): array
    {
        return [
            'simple' => [
                '<blogvh:link.archive year="2023" />',
                '<a href="/archive/archive/2023">2023</a>',
            ],
            'month' => [
                '<blogvh:link.archive year="2023" month="5" />',
                '<a href="/archive/archive/2023/may">2023-5</a>',
            ],
            'target' => [
                '<blogvh:link.archive year="2023" target="_blank" />',
                '<a target="_blank" href="/archive/archive/2023">2023</a>',
            ],
            'rel' => [
                '<blogvh:link.archive year="2023" rel="noreferrer" />',
                '<a rel="noreferrer" href="/archive/archive/2023">2023</a>',
            ],
            'rss' => [
                '<blogvh:link.archive year="2023" rss="true" />',
                '<a href="/archive/archive/2023/blog.archive.xml">2023</a>',
            ],
            'content' => [
                '<blogvh:link.archive year="2023">Hello</blogvh:link.archive>',
                '<a href="/archive/archive/2023">Hello</a>',
            ],
            'class' => [
                '<blogvh:link.archive year="2023" class="class" />',
                '<a class="class" href="/archive/archive/2023">2023</a>',
            ],
        ];
    }
}
