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
use T3G\AgencyPack\Blog\Tests\Functional\SiteBasedTestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class PersonViewHelperTest extends SiteBasedTestCase
{
    #[Test]
    #[DataProvider('renderDataProvider')]
    public function render(string $template, string $expected): void
    {
        $this->createTestSite();

        (new ConnectionPool())->getConnectionForTable('tx_blog_domain_model_author')->insert(
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

        $instructions = [
            [
                'type' => 'author',
                'uid' => 100,
                'as' => 'author',
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
                '<blogvh:schema.person author="{test.author}" />',
                '{"@context":"https://schema.org","@type":"Person","name":"TYPO3 Inc Team","@id":"https://my.typo3.org/u/typo3-inc-team/#Person","url":"https://my.typo3.org/u/typo3-inc-team","sameAs":["https://my.typo3.org/u/typo3-inc-team"]}',
            ],
        ];
    }
}
