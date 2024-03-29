<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link;

use T3G\AgencyPack\Blog\Domain\Model\Category;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
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
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');

        $this->registerArgument('category', Category::class, 'The category to link to', true);
        $this->registerArgument('rss', 'bool', 'Link to rss version', false, false);
    }

    public function render(): string
    {
        $rssFormat = (bool)$this->arguments['rss'];
        /** @var Category $category */
        $category = $this->arguments['category'];
        $pageUid = (int)$this->getTypoScriptFrontendController()->tmpl->setup['plugin.']['tx_blog.']['settings.']['categoryUid'];
        $arguments = [
            'category' => $category->getUid(),
        ];
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uriBuilder->reset()
            ->setRequest($this->renderingContext->getRequest())
            ->setTargetPageUid($pageUid);
        if ($rssFormat) {
            $uriBuilder
                ->setTargetPageType((int)$this->getTypoScriptFrontendController()->tmpl->setup['blog_rss_category.']['typeNum']);
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

    protected function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
