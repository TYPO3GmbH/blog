<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service\Avatar;

use Psr\Http\Message\UriInterface;
use T3G\AgencyPack\Blog\DataTransferObject\AvatarResource;

interface AvatarResourceResolverInterface
{
    public function resolve(UriInterface $uri): AvatarResource;
}
