<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use T3G\AgencyPack\Blog\Domain\Model\Category;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class CategoryViewHelper.
 */
class CategoryViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * CategoryViewHelper constructor.
     */
    public function __construct()
    {
        $this->tagName = 'a';
        parent::__construct();
    }

    /**
     * Arguments initialization.
     *
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link', false);
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document', false);

        $this->registerArgument('category', Category::class, 'The category to link to', true);
        $this->registerArgument('rss', 'bool', 'Link to rss version', false, false);
    }

    /**
     * @return string Rendered page URI
     */
    public function render()
    {
        $rssFormat = (bool) $this->arguments['rss'];
        /** @var Category $category */
        $category = $this->arguments['category'];
        $pageUid = (int) $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_blog.']['settings.']['categoryUid'];
        $additionalParams = [
            'tx_blog_category' => [
                'category' => $category->getUid(),
            ],
        ];
        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset()
            ->setTargetPageUid($pageUid)
            ->setUseCacheHash(true)
            ->setArguments($additionalParams);
        if ($rssFormat) {
            $uriBuilder
                ->setFormat('rss')
                ->setTargetPageType($GLOBALS['TSFE']->tmpl->setup['blog_rss_category.']['typeNum']);
        }
        $uri = $uriBuilder->uriFor('listPostsByCategory', [], 'Post', 'Blog');

        if ((string) $uri !== '') {
            $linkText = $this->renderChildren() ?: $category->getTitle();
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }

        return $result;
    }
}
