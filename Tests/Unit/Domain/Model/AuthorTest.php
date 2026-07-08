<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Domain\Model;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class AuthorTest extends UnitTestCase
{
    /**
     * @return array<string, array{string, string}>
     */
    public static function mastodonHandleDataProvider(): array
    {
        return [
            'profile url' => ['https://norden.social/@neoblack', '@neoblack@norden.social'],
            'profile url with trailing slash' => ['https://typo3.social/@username/', '@username@typo3.social'],
            'handle' => ['@username@typo3.social', '@username@typo3.social'],
            'empty value' => ['', ''],
            'unsupported url path' => ['https://typo3.social/users/username', ''],
        ];
    }

    #[DataProvider('mastodonHandleDataProvider')]
    #[Test]
    public function getMastodonHandleReturnsFediverseHandle(string $mastodon, string $expected): void
    {
        $author = (new Author())->setMastodon($mastodon);

        self::assertSame($expected, $author->getMastodonHandle());
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function mastodonProfileUrlDataProvider(): array
    {
        return [
            'profile url' => ['https://norden.social/@neoblack', 'https://norden.social/@neoblack'],
            'handle' => ['@username@typo3.social', 'https://typo3.social/@username'],
            'empty value' => ['', ''],
            'unsupported value' => ['username', ''],
        ];
    }

    #[DataProvider('mastodonProfileUrlDataProvider')]
    #[Test]
    public function getMastodonProfileUrlReturnsProfileUrl(string $mastodon, string $expected): void
    {
        $author = (new Author())->setMastodon($mastodon);

        self::assertSame($expected, $author->getMastodonProfileUrl());
    }
}
