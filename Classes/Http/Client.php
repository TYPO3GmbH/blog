<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Http;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Backport of https://github.com/TYPO3-CMS/core/blob/10.4/Classes/Http/Client.php
 *
 * Must be removed as soon as t3g/blog's minimum requirement is typo3/cms-core:^10.4
 */
class Client implements ClientInterface
{
    /**
     * @var GuzzleClientInterface
     */
    private $guzzle;

    public function __construct(GuzzleClientInterface $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ClientExceptionInterface If an error happens while processing the request.
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $clientException = new class extends \Exception implements ClientExceptionInterface {
        };

        try {
            return $this->guzzle->send($request, [
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::ALLOW_REDIRECTS => false,
            ]);
        } catch (ConnectException $e) {
            throw new $clientException($e->getMessage(), 1566909446, $e->getRequest(), $e);
        } catch (RequestException $e) {
            throw new $clientException($e->getMessage(), 1566909447, $e->getRequest(), $e);
        } catch (GuzzleException $e) {
            throw new $clientException($e->getMessage(), 1566909448, $e);
        }
    }
}
