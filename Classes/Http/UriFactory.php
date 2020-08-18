<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Http;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use TYPO3\CMS\Core\Http\Uri;

/**
 * Backport of https://github.com/TYPO3-CMS/core/blob/10.4/Classes/Http/UriFactory.php
 *
 * Must be removed as soon as t3g/blog's minimum requirement is typo3/cms-core:^10.4
 */
class UriFactory implements UriFactoryInterface
{
    /**
     * Create a new URI.
     *
     * @param string $uri
     * @return UriInterface
     * @throws \InvalidArgumentException If the given URI cannot be parsed.
     */
    public function createUri(string $uri = ''): UriInterface
    {
        return new Uri($uri);
    }
}
