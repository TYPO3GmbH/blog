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
use T3G\AgencyPack\Blog\Domain\Model\Category;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class CategoryViewHelper extends AbstractTagBasedViewHelper
{
    public function __construct()
    {
        $this->tagName = 'a';
        parent::__construct();
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('category', Category::class, 'The category to link to', true);
        $this->registerArgument('rss', 'bool', 'Link to rss version', false, false);
    }

    public function render(): string
    {
        $rssFormat = (bool)$this->arguments['rss'];
        /** @var Category $category */
        $category = $this->arguments['category'];
        $pageUid = (int)($this->getRequest()->getAttribute('frontend.typoscript')->getSetupTree()
            ->getChildByName('plugin')
            ?->getChildByName('tx_blog')
            ?->getChildByName('settings')
            ?->getChildByName('categoryUid')
            ?->getValue() ?? 0);
        $arguments = [
            'category' => $category->getUid(),
        ];
        $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uriBuilder->reset()
            ->setRequest($request)
            ->setTargetPageUid($pageUid);
        if ($rssFormat) {
            $rssTypeNum = (int)(
                $this->getRequest()->getAttribute('frontend.typoscript')->getSetupTree()
                ->getChildByName('blog_rss_category')
                ?->getChildByName('typeNum')
                ?->getValue() ?? 0
            );
            $uriBuilder->setTargetPageType($rssTypeNum);
        }
        $uri = $uriBuilder->uriFor('listPostsByCategory', $arguments, 'Post', 'Blog', 'Category');

        if ($uri !== '') {
            $linkText = $this->renderChildren() ?? $category->getTitle();
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
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
                'ViewHelper blogvh:link.category needs a request implementing ServerRequestInterface.',
                1729082935
            );
        }
        return $request;
    }
}
