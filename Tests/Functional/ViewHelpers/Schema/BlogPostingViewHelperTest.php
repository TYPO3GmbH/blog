<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\ViewHelpers\Schema;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Tests\Functional\SiteBasedTestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class BlogPostingViewHelperTest extends SiteBasedTestCase
{
    #[Test]
    #[DataProvider('renderDataProvider')]
    public function render(string $template, string $expected): void
    {
        $this->createTestSite();
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);

        $connectionPool->getConnectionForTable('pages')->insert(
            'pages',
            [
                'uid' => 100,
                'pid' => self::STORAGE_UID,
                'doktype' => Constants::DOKTYPE_BLOG_POST,
                'title' => 'First blog post',
                'slug' => '/first-blog-post',
                'authors' => 1,
            ]
        );

        $connectionPool->getConnectionForTable('tx_blog_domain_model_author')->insert(
            'tx_blog_domain_model_author',
            [
                'uid' => 100,
                'pid' => self::STORAGE_UID,
                'name' => 'TYPO3 Inc Team',
                'slug' => 'typo3-inc-team',
                'posts' => 1,
                'profile' => 'https://my.typo3.org/u/typo3-inc-team',
            ]
        );

        $connectionPool->getConnectionForTable('tx_blog_post_author_mm')->insert(
            'tx_blog_post_author_mm',
            [
                'uid_local' => 100,
                'uid_foreign' => 100,
                'sorting' => 1,
                'sorting_foreign' => 1,
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

    #[Test]
    public function markupInAPostTitleCannotEscapeTheScriptElement(): void
    {
        $this->createTestSite();

        GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages')->insert(
            'pages',
            [
                'uid' => 100,
                'pid' => self::STORAGE_UID,
                'doktype' => Constants::DOKTYPE_BLOG_POST,
                'title' => 'Mallory</script><img src=x onerror=alert(1)>',
                'slug' => '/hostile-blog-post',
            ]
        );

        $rendered = $this->renderFluidTemplateInTestSite(
            '<blogvh:schema.blogPosting post="{test.post}" />',
            [
                [
                    'type' => 'post',
                    'uid' => 100,
                    'as' => 'post',
                ]
            ]
        );

        // The value survives, so the assertions below are not met by a dropped field.
        self::assertStringContainsString('Mallory', $rendered);
        self::assertStringNotContainsString('</script>', $rendered);
        self::assertStringNotContainsString('<img', $rendered);
    }

    public static function renderDataProvider(): array
    {
        return [
            'simple' => [
                '<blogvh:schema.blogPosting post="{test.post}" />',
                '{"@context":"https://schema.org","@type":"BlogPosting","headline":"First blog post","mainEntityOfPage":{"@type":"WebPage","@id":"https://test.typo3.com/first-blog-post"},"author":{"@context":"https://schema.org","@type":"Person","name":"TYPO3 Inc Team","@id":"https://my.typo3.org/u/typo3-inc-team/#Person","url":"https://my.typo3.org/u/typo3-inc-team","sameAs":["https://my.typo3.org/u/typo3-inc-team"]}}',
            ],
        ];
    }
}
