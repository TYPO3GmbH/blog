<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service\Avatar\Gravatar;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

final class GravatarUriBuilder implements GravatarUriBuilderInterface
{
    private const BASE_URI = 'https://www.gravatar.com/';
    private const DEFAULT_SIZE = 72;
    private const DEFAULT_RATING = 'g';
    private const DEFAULT_DEFAULT = 'mm';

    /**
     * @var UriFactoryInterface
     */
    private $uriFactory;

    public function __construct(UriFactoryInterface $uriFactory)
    {
        $this->uriFactory = $uriFactory;
    }

    public function getUri(string $email, ?int $size = null, ?string $rating = null, ?string $default = null): UriInterface
    {
        $emailHash = md5($email);
        $queryData = [
            's' => $size ?? static::DEFAULT_SIZE,
            'r' => $rating ?? static::DEFAULT_RATING,
            'd' => $default ?? static::DEFAULT_DEFAULT,
        ];

        return $this->uriFactory->createUri(self::BASE_URI)
            ->withPath('avatar/' . $emailHash)
            ->withQuery(http_build_query($queryData))
        ;
    }
}
