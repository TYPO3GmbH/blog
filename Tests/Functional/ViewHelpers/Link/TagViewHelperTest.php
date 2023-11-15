<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\ViewHelpers\Link;

use T3G\AgencyPack\Blog\Tests\Functional\SiteBasedTestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class TagViewHelperTest extends SiteBasedTestCase
{
    /**
     * @test
     * @dataProvider renderDataProvider
     */
    public function render(string $template, string $expected): void
    {
        $this->createTestSite();

        (new ConnectionPool())->getConnectionForTable('pages')->insert(
            'tx_blog_domain_model_tag',
            [
                'uid' => 100,
                'pid' => self::STORAGE_UID,
                'title' => 'TYPO3',
                'slug' => 'typo3'
            ]
        );

        $instructions = [
            [
                'type' => 'tag',
                'uid' => 100,
                'as' => 'tag',
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
                '<blogvh:link.tag tag="{test.tag}" />',
                '<a href="/tag/tag/typo3">TYPO3</a>',
            ],
            'rel' => [
                '<blogvh:link.tag tag="{test.tag}" rel="noreferrer" />',
                '<a rel="noreferrer" href="/tag/tag/typo3">TYPO3</a>',
            ],
            'target' => [
                '<blogvh:link.tag tag="{test.tag}" target="_blank" />',
                '<a target="_blank" href="/tag/tag/typo3">TYPO3</a>',
            ],
            'rss' => [
                '<blogvh:link.tag tag="{test.tag}" rss="true" />',
                '<a href="/tag/tag/typo3/blog.tag.xml">TYPO3</a>',
            ],
            'content' => [
                '<blogvh:link.tag tag="{test.tag}">Hello</blogvh:link.tag>',
                '<a href="/tag/tag/typo3">Hello</a>',
            ],
            'class' => [
                '<blogvh:link.tag tag="{test.tag}" class="class" />',
                '<a class="class" href="/tag/tag/typo3">TYPO3</a>',
            ],
        ];
    }
}
