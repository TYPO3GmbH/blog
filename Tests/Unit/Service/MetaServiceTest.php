<?php

namespace T3G\AgencyPack\Blog\Tests\Unit\Service;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use T3G\AgencyPack\Blog\Service\MetaService;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Class MetaServiceTest.
 */
class MetaServiceTest extends UnitTestCase
{
    /**
     * @var MetaService
     */
    protected $metaService;

    /**
     *
     */
    public function setUp()
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
        MetaService::set($key, $key);
        self::assertSame($key, MetaService::get($key));
    }
}
