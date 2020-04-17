<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit;

use T3G\AgencyPack\Blog\Constants;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ConstantsTest extends UnitTestCase
{
    /**
     * @test
     */
    public function constantForDoktypeOfBlogPostsIsSetCorrectly()
    {
        self::assertEquals(137, Constants::DOKTYPE_BLOG_POST);
        self::assertEquals(138, Constants::DOKTYPE_BLOG_PAGE);
    }
}
