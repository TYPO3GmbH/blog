<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Service\Avatar\Gravatar;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use T3G\AgencyPack\Blog\Http\RequestFactory;
use T3G\AgencyPack\Blog\Service\Avatar\Gravatar\GravatarResourceResolver;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class GravatarResourceResolverTest extends UnitTestCase
{
    public function testResolveReturnsProperResponse(): void
    {
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $response->expects(self::any())
            ->method('getStatusCode')
            ->willReturn(200);
        $response->expects(self::any())
            ->method('getBody')
            ->willReturn(new Stream('php://temp'));
        $response->expects(self::any())
            ->method('getHeaderLine')
            ->willReturn('image/jpeg');

        $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $client->expects(self::any())
            ->method('sendRequest')
            ->willReturn($response);

        $gravatarResourceResolver = new GravatarResourceResolver(
            $client,
            new RequestFactory()
        );

        $url = 'https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164';
        $avatarResource = $gravatarResourceResolver->resolve(new Uri($url));

        self::assertSame($url, (string)$avatarResource->getUri());
        self::assertSame('image/jpeg', $avatarResource->getContentType());
        self::assertSame('', $avatarResource->getContent());
    }

    public function testResolveReturnsResponseWith404StatusCode(): void
    {
        $this->expectException(\RuntimeException::class);

        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $response->expects(self::any())
            ->method('getStatusCode')
            ->willReturn(404);
        $response->expects(self::any())
            ->method('getReasonPhrase')
            ->willReturn('Not Found');

        $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $client->expects(self::any())
            ->method('sendRequest')
            ->willReturn($response);

        $gravatarResourceResolver = new GravatarResourceResolver(
            $client,
            new RequestFactory()
        );

        $url = 'https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164';
        $gravatarResourceResolver->resolve(new Uri($url));
    }

    public function testResolveReturnsResponseWithEmptyContentTypeHeader(): void
    {
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $response->expects(self::any())
            ->method('getStatusCode')
            ->willReturn(200);
        $response->expects(self::any())
            ->method('getBody')
            ->willReturn(new Stream('php://temp'));
        $response->expects(self::any())
            ->method('getHeaderLine')
            ->willReturn('');

        $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $client->expects(self::any())
            ->method('sendRequest')
            ->willReturn($response);

        $gravatarResourceResolver = new GravatarResourceResolver(
            $client,
            new RequestFactory()
        );

        $url = 'https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164';
        $avatarResource = $gravatarResourceResolver->resolve(new Uri($url));

        self::assertSame($url, (string)$avatarResource->getUri());
        self::assertSame('text/plain', $avatarResource->getContentType());
        self::assertSame('', $avatarResource->getContent());
    }
}
