<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Service;

use T3G\AgencyPack\Blog\Service\MetaService;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class MetaServiceTest extends UnitTestCase
{
    /**
     * @var MetaService
     */
    protected $metaService;

    public function initialize()
    {
        $this->metaService = MetaService::getInstance();
    }

    /**
     * @return array
     */
    public function metaDataDataProvider() : array
    {
        return [
            MetaService::META_TITLE => [MetaService::META_TITLE],
            MetaService::META_DESCRIPTION => [MetaService::META_DESCRIPTION],
            MetaService::META_PUBLISHED_DATE => [MetaService::META_PUBLISHED_DATE],
            MetaService::META_MODIFIED_DATE => [MetaService::META_MODIFIED_DATE],
            MetaService::META_URL => [MetaService::META_URL],
            MetaService::META_TAGS => [MetaService::META_TAGS],
            MetaService::META_CATEGORIES => [MetaService::META_CATEGORIES],
        ];
    }

    /**
     * @test
     * @dataProvider metaDataDataProvider
     *
     * @param string $key
     */
    public function ensureDataCanStoredInMetaService(string $key)
    {
        $this->initialize();

        MetaService::set($key, $key);
        self::assertSame($key, MetaService::get($key));
    }
}
