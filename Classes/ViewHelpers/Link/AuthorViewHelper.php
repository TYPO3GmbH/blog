<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class AuthorViewHelper extends AbstractTagBasedViewHelper
{
    public function __construct()
    {
        $this->tagName = 'a';
        parent::__construct();
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('author', Author::class, 'The author to link to', true);
        $this->registerArgument('rss', 'bool', 'Link to rss version', false, false);
    }

    public function render(): string
    {
        /** @var Author $author */
        $author = $this->arguments['author'];
        $rssFormat = (bool)$this->arguments['rss'];

        if ((int)$author->getDetailsPage() > 0 && !$rssFormat) {
            return $this->buildUriFromDetailsPage($author, $rssFormat);
        }

        return $this->buildUriFromDefaultPage($author, $rssFormat);
    }

    protected function buildUriFromDetailsPage(Author $author, bool $rssFormat): string
    {
        $uriBuilder = $this->getUriBuilder((int) $author->getDetailsPage(), [], $rssFormat);
        return $this->buildAnchorTag($uriBuilder->build(), $author);
    }

    protected function buildUriFromDefaultPage(Author $author, bool $rssFormat): string
    {
        $settings = $this->getRequest()->getAttribute('frontend.typoscript')->getSetupTree()
            ->getChildByName('plugin')
            ?->getChildByName('tx_blog')
            ?->getChildByName('settings')
            ?->toArray() ?? [];
        $authorUid = (int)($settings['authorUid'] ?? 0);
        $uriBuilder = $this->getUriBuilder($authorUid, [], $rssFormat);
        $arguments = [
            'author' => $author->getUid(),
        ];
        return $this->buildAnchorTag($uriBuilder->uriFor('listPostsByAuthor', $arguments, 'Post', 'Blog', 'AuthorPosts'), $author);
    }

    protected function getUriBuilder(int $pageUid, array $additionalParams, bool $rssFormat): UriBuilder
    {
        $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uriBuilder->reset()
            ->setRequest($request)
            ->setTargetPageUid($pageUid)
            ->setArguments($additionalParams);
        if ($rssFormat) {
            $rssTypeNum = (int)(
                $this->getRequest()->getAttribute('frontend.typoscript')->getSetupTree()
                ->getChildByName('blog_rss_author')
                ?->getChildByName('typeNum')
                ?->getValue() ?? 0
            );
            $uriBuilder
                ->setTargetPageType($rssTypeNum);
        }

        return $uriBuilder;
    }

    protected function buildAnchorTag(string $uri, Author $author): string
    {
        if ($uri !== '') {
            $linkText = $this->renderChildren() ?? $author->getName();
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            return $this->tag->render();
        }

        return $this->renderChildren();
    }

    protected function getRequest(): ServerRequestInterface
    {
        $request = null;
        if ($this->renderingContext->hasAttribute(ServerRequestInterface::class)) {
            $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        }
        $request ??= $GLOBALS['TYPO3_REQUEST'] ?? null;
        if (!$request instanceof ServerRequestInterface) {
            throw new \RuntimeException(
                'ViewHelper blogvh:link.author needs a request implementing ServerRequestInterface.',
                1729082934
            );
        }
        return $request;
    }
}
