<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\AvatarProvider;

use T3G\AgencyPack\Blog\AvatarProvider\GravatarProvider;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class GravatarProviderTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        $this->coreExtensionsToLoad[] = 'extbase';
        $this->testExtensionsToLoad[] = 'typo3conf/ext/blog';

        parent::setUp();
    }

    public function testGetAvatarUrlReturnsOriginalGravatarComUrl(): void
    {
        $gravatarProvider = new GravatarProvider();
        self::assertSame(
            'https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164',
            $gravatarProvider->getAvatarUrl((new Author())->setEmail('name@host.tld'))
        );
    }

    public function testGetAvatarUrlReturnsTypo3TempUrl(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['blog']['enableGravatarProxy'] = '1';

        $gravatarProvider = new GravatarProvider();
        self::assertStringStartsWith(
            'typo3temp/assets/t3g/blog/gravatar/',
            $gravatarProvider->getAvatarUrl((new Author())->setEmail('name@host.tld'))
        );
    }
}
