<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link\Be;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Routing\Route;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class AuthorViewHelper extends AbstractTagBasedViewHelper
{
    public function __construct()
    {
        $this->tagName = 'a';
        parent::__construct();
    }

    /**
     * Arguments initialization.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link');
        $this->registerTagAttribute('itemprop', 'string', 'itemprop attribute');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');

        $this->registerArgument('author', Author::class, 'The author to link to');
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
    }

    /**
     * @return string Rendered page URI
     *
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     * @throws \InvalidArgumentException
     */
    public function render(): string
    {
        /** @var Author $author */
        $author = $this->arguments['author'];
        $authorUid = (int)$author->getUid();

        $routingUriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uri = $routingUriBuilder->buildUriFromRoute('record_edit', ['edit[tx_blog_domain_model_author][' . $authorUid . ']' => 'edit']);
        $arguments = GeneralUtility::_GET();
        $request = $this->getRequest();
        /** @var Route $route */
        $route = $request->getAttribute('route');
        unset($arguments['route'], $arguments['token']);
        $uri .= '&returnUrl=' . rawurlencode((string)GeneralUtility::makeInstance(UriBuilder::class)->buildUriFromRoute($route->getOption('_identifier'), $arguments));
        if ($uri !== '') {
            if ($this->arguments['returnUri']) {
                return $uri;
            }
            $linkText = $this->renderChildren() ?: $author->getName();
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }

        return $result;
    }

    protected function getRequest(): ?ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

}
