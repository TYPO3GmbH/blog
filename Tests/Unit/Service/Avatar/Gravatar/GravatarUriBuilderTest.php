<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Service\Avatar\Gravatar;

use T3G\AgencyPack\Blog\Service\Avatar\Gravatar\GravatarUriBuilder;
use TYPO3\CMS\Core\Http\UriFactory;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class GravatarUriBuilderTest extends UnitTestCase
{
    /**
     * @var GravatarUriBuilder
     */
    protected $gravatarUriBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gravatarUriBuilder = new GravatarUriBuilder(new UriFactory());
    }

    /**
     * @dataProvider getUriDataProvider
     * @param string $expectedUriString
     * @param string $email
     * @param int|null $size
     * @param string|null $rating
     * @param string|null $default
     */
    public function testGetUri(string $expectedUriString, string $email, ?int $size, ?string $rating, ?string $default): void
    {
        self::assertSame(
            $expectedUriString,
            (string)$this->gravatarUriBuilder->getUri($email, $size, $rating, $default)
        );
    }

    public static function getUriDataProvider(): \Generator
    {
        $email = 'name@host.tld';
        yield ['https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164', $email, null, null, null];
        yield ['https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164?s=10', $email, 10, null, null];
        yield ['https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164?r=r', $email, null, 'r', null];
        yield ['https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164?d=mm', $email, null, null, 'mm'];
        yield ['https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164?s=10&r=r', $email, 10, 'r', null];
        yield ['https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164?r=r&d=mm', $email, null, 'r', 'mm'];
        yield ['https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164?s=10&d=mm', $email, 10, null, 'mm'];
        yield ['https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164?s=10&r=r&d=mm', $email, 10, 'r', 'mm'];
    }
}
