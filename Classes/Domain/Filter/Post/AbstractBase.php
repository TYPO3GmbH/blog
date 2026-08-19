<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Filter\Post;

use T3G\AgencyPack\Blog\Domain\Filter\PostFilter;

/**
 * Base class for all post filters.
 */
abstract class AbstractBase implements PostFilter
{
    /**
     * The class name (without namespace) is used as the filter's name.
     */
    public function getName(): string
    {
        $classWithNamespace = get_class($this);
        $rightBackslash = strrpos($classWithNamespace, '\\') ?? 0;
        return substr($classWithNamespace, $rightBackslash > 0 ? ++$rightBackslash : $rightBackslash);
    }
}
