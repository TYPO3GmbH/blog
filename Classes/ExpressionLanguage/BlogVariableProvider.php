<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ExpressionLanguage;

use T3G\AgencyPack\Blog\Constants;

/**
 * BlogVariableProvider
 */
class BlogVariableProvider
{
    /**
     * @return bool
     */
    public function isPost(): bool
    {
        $page = $GLOBALS['TSFE']->page ?? [];
        return $page['doktype'] == Constants::DOKTYPE_BLOG_POST;
    }
}
