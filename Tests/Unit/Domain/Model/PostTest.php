<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Domain\Model;

use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Tests for domains model News
 *
 */
class PostTest extends UnitTestCase
{
    #[Test]
    public function doktypeEqualsConstant(): void
    {
        $post = new Post();
        self::assertEquals(Constants::DOKTYPE_BLOG_POST, $post->getDoktype());
    }
}
