<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use T3G\AgencyPack\Blog\Service\CategoryTargetPageResolver;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;

/**
 * Redirects the automatically generated category pages to the pages
 * categories have been assigned to.
 *
 * Without such an assignment nothing is redirected, the automatically
 * generated category page keeps answering the request as before.
 */
readonly class CategoryPageRedirect implements MiddlewareInterface
{
    public function __construct(
        protected CategoryTargetPageResolver $categoryTargetPageResolver
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $targetPageUid = $this->resolveTargetPage($request);
        if ($targetPageUid === null) {
            return $handler->handle($request);
        }

        /** @var Site $site */
        $site = $request->getAttribute('site');
        $language = $request->getAttribute('language');
        $parameters = $language instanceof SiteLanguage ? ['_language' => $language] : [];

        return new RedirectResponse($site->getRouter()->generateUri($targetPageUid, $parameters), 301);
    }

    private function resolveTargetPage(ServerRequestInterface $request): ?int
    {
        $site = $request->getAttribute('site');
        $pageArguments = $request->getAttribute('routing');
        if (!$site instanceof Site || !$pageArguments instanceof PageArguments) {
            return null;
        }

        // Feeds and other page types are still delivered by the blog itself.
        if ((int)$pageArguments->getPageType() !== 0) {
            return null;
        }

        $categoryPageUid = (int)($site->getSettings()->get('plugin.tx_blog.settings.categoryUid') ?? 0);
        if ($categoryPageUid === 0 || $pageArguments->getPageId() !== $categoryPageUid) {
            return null;
        }

        $categoryUid = $this->getCategoryArgument($request, $pageArguments);
        $targetPageUid = $categoryUid === null
            ? (int)($site->getSettings()->get('plugin.tx_blog.settings.categoryOverviewUid') ?? 0)
            : (int)$this->categoryTargetPageResolver->resolve($categoryUid);

        // Never redirect a page to itself.
        if ($targetPageUid === 0 || $targetPageUid === $categoryPageUid) {
            return null;
        }

        return $targetPageUid;
    }

    private function getCategoryArgument(ServerRequestInterface $request, PageArguments $pageArguments): ?int
    {
        $category = $pageArguments->getRouteArguments()['tx_blog_category']['category']
            ?? $request->getQueryParams()['tx_blog_category']['category']
            ?? null;

        return $category === null ? null : (int)$category;
    }
}
