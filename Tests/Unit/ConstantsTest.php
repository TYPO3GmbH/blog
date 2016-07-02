<?php
namespace T3G\AgencyPack\Blog\Tests\Unit;

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
use T3G\AgencyPack\Blog\Constants;

/**
 * Test case
 *
 */
class ConstantsTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @test
     */
    public function constantForDoktypeOfBlogPostsIsSetCorrectly()
    {
        self::assertEquals(137, Constants::DOKTYPE_BLOG_POST);
    }
}