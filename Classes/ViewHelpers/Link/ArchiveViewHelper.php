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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class ArchiveViewHelper extends AbstractTagBasedViewHelper
{
    public function __construct()
    {
        $this->tagName = 'a';
        parent::__construct();
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('month', 'int', 'The month to link to');
        $this->registerArgument('year', 'int', 'The year to link to', true);
        $this->registerArgument('rss', 'bool', 'Link to rss version', false, false);
    }

    public function render(): string
    {
        $request = $this->getRequest();
        $rssFormat = (bool)$this->arguments['rss'];
        $year = (int)$this->arguments['year'];
        $month = (int)$this->arguments['month'];
        $pageUid = $request
            ->getAttribute('site')
            ->getSettings()
            ->get('plugin.tx_blog.settings.archiveUid') ?? 0;

        $rssTypeNum = (int)(
            $request->getAttribute('frontend.typoscript')->getSetupTree()
            ->getChildByName('blog_rss_archive')
            ?->getChildByName('typeNum')
            ?->getValue() ?? 0
        );

        $arguments = [
            'year' => $year
        ];
        if ($month > 0) {
            $arguments['month'] = $month;
        }
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uriBuilder->reset()
            ->setRequest($request)
            ->setTargetPageUid($pageUid);
        if ($rssFormat) {
            $uriBuilder
                ->setTargetPageType($rssTypeNum);
        }
        $uri = $uriBuilder->uriFor('listPostsByDate', $arguments, 'Post', 'Blog', 'Archive');
        $linkText = $this->renderChildren() ?? implode('-', $arguments);
        if ($uri !== '') {
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent((string)$linkText);
            $result = $this->tag->render();
        } else {
            $result = $linkText;
        }

        return (string)$result;
    }

    protected function getRequest(): RequestInterface
    {
        $request = null;
        if ($this->renderingContext->hasAttribute(ServerRequestInterface::class)) {
            $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        }

        if ($request === null || !$request instanceof RequestInterface) {
            throw new \RuntimeException(
                'ViewHelper blogvh:link.archive can be used only in extbase context and needs a request implementing extbase RequestInterface.',
                1729082933
            );
        }

        return $request;
    }
}
