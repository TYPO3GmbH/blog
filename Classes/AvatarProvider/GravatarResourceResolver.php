<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\AvatarProvider;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class GravatarResourceResolver implements AvatarResourceResolverInterface, LoggerAwareInterface
{
    protected const HTTP_METHOD = 'GET';
    private const HTTP_OK_STATUS_CODE = 200;

    use LoggerAwareTrait;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    final public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
    }

    final public function resolve(UriInterface $uri): ?AvatarResource
    {
        $request = $this->requestFactory->createRequest(static::HTTP_METHOD, $uri);
        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            $this->logger->error($e->getMessage(), []);
            return null;
        }

        if ($response->getStatusCode() !== self::HTTP_OK_STATUS_CODE) {
            $this->logger->error(sprintf(
                'HTTP request "%s %s" returned non 200 status code "%d %s"',
                static::HTTP_METHOD,
                (string)$uri,
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));
            return null;
        }

        $response->getBody()->rewind();
        return new Gravatar(
            $uri,
            $response->getHeaderLine('Content-Type') ?? 'text/plain',
            $response->getBody()->getContents()
        );
    }
}
