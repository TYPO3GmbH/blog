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
        $rssFormat = (bool)$this->arguments['rss'];
        $year = (int)$this->arguments['year'];
        $month = (int)$this->arguments['month'];
        // @todo migrate to site settings
        $pageUid = (int)($this->getRequest()->getAttribute('frontend.typoscript')->getSetupTree()
            ->getChildByName('plugin')
            ?->getChildByName('tx_blog')
            ?->getChildByName('settings')
            ?->getChildByName('archiveUid')
            ?->getValue() ?? 0);

        $rssTypeNum = (int)(
            $this->getRequest()->getAttribute('frontend.typoscript')->getSetupTree()
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
        $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
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

    protected function getRequest(): ServerRequestInterface
    {
        $request = null;
        if ($this->renderingContext->hasAttribute(ServerRequestInterface::class)) {
            $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        }
        $request ??= $GLOBALS['TYPO3_REQUEST'] ?? null;
        if (!$request instanceof ServerRequestInterface) {
            throw new \RuntimeException(
                'ViewHelper blogvh:link.archive needs a request implementing ServerRequestInterface.',
                1729082933
            );
        }
        return $request;
    }
}
