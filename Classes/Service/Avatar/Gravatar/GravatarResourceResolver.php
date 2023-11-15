<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service\Avatar\Gravatar;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriInterface;
use T3G\AgencyPack\Blog\DataTransferObject\AvatarResource;
use T3G\AgencyPack\Blog\DataTransferObject\Gravatar;
use T3G\AgencyPack\Blog\Service\Avatar\AvatarResourceResolverInterface;

final class GravatarResourceResolver implements AvatarResourceResolverInterface
{
    private const HTTP_METHOD = 'GET';
    private const HTTP_OK_STATUS_CODE = 200;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws \RuntimeException
     */
    public function resolve(UriInterface $uri): AvatarResource
    {
        $request = $this->requestFactory->createRequest(static::HTTP_METHOD, $uri);
        $response = $this->client->sendRequest($request);

        if ($response->getStatusCode() !== self::HTTP_OK_STATUS_CODE) {
            throw new \RuntimeException(sprintf(
                'HTTP request "%s %s" returned non 200 status code "%d %s"',
                static::HTTP_METHOD,
                (string)$uri,
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));
        }

        $contentType = $response->getHeaderLine('Content-Type');
        $contentType = $contentType !== '' ? $contentType : 'text/plain';

        $response->getBody()->rewind();
        return new Gravatar(
            $uri,
            $contentType,
            $response->getBody()->getContents()
        );
    }
}
