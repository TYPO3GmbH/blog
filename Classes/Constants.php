<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog;

class Constants
{
    /**
     * Named constants for "magic numbers" of the field pages.doktype.
     */
    public const DOKTYPE_BLOG_POST = 137;
    public const DOKTYPE_BLOG_PAGE = 138;

    /**
     * Named constants for "magic numbers" of the field sys_category.category_type.
     */
    public const CATEGORY_TYPE_DEFAULT = 1;
    public const CATEGORY_TYPE_BLOG = 100;
}
