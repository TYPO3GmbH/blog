<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Utility\Socials;

use PHPUnit\Framework\Attributes\DataProvider;
use T3G\AgencyPack\Blog\Utility\Socials\MastodonUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class MastodonUtilityTest extends UnitTestCase
{
    /**
     * @return array<string, array{string, string}>
     */
    public static function mastodonHandleDataProvider(): array
    {
        return [
            'profile url' => ['https://typo3.social/@typo3blog', '@typo3blog@typo3.social'],
            'profile url with trailing slash' => ['https://typo3.social/@username/', '@username@typo3.social'],
            'handle' => ['@username@typo3.social', '@username@typo3.social'],
            'empty value' => ['', ''],
            'unsupported url path' => ['https://typo3.social/users/username', ''],
        ];
    }

    #[DataProvider('mastodonHandleDataProvider')]
    public function testGetMastodonHandle(string $mastodon, string $expected): void
    {
        self::assertSame($expected, MastodonUtility::getMastodonHandle($mastodon));
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function mastodonUrlDataProvider(): array
    {
        return [
            'profile url' => ['https://typo3.social/@typo3blog', 'https://typo3.social/@typo3blog'],
            'handle' => ['@username@typo3.social', 'https://typo3.social/@username'],
            'empty value' => ['', ''],
            'unsupported value' => ['username', ''],
        ];
    }

    #[DataProvider('mastodonUrlDataProvider')]
    public function testGetMastodonUrl(string $mastodon, string $expected): void
    {
        self::assertSame($expected, MastodonUtility::getMastodonUrl($mastodon));
    }
}
