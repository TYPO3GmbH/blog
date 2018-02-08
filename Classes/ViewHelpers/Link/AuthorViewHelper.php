<?php

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
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class AuthorViewHelper.
 */
class AuthorViewHelper extends AbstractTagBasedViewHelper
{
    /** @var RenderingContext */
    protected $renderingContext;

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
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');

        $this->registerArgument('author', Author::class, 'The author to link to', true);
        $this->registerArgument('rss', 'bool', 'Link to rss version', false, false);
    }

    /**
     * @return string Rendered page URI
     */
    public function render(): string
    {
        $rssFormat = (bool) $this->arguments['rss'];
        /** @var Author $author */
        $author = $this->arguments['author'];
        $pageUid = (int) $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_blog.']['settings.']['authorUid'];
        $additionalParams = [
            'tx_blog_authorposts' => [
                'author' => $author->getUid(),
            ],
        ];
        $uriBuilder = $this->renderingContext->getControllerContext()->getUriBuilder();
        $uriBuilder->reset()
            ->setTargetPageUid($pageUid)
            ->setUseCacheHash(true)
            ->setArguments($additionalParams);
        if ($rssFormat) {
            $uriBuilder
                ->setFormat('rss')
                ->setTargetPageType($GLOBALS['TSFE']->tmpl->setup['blog_rss_author.']['typeNum']);
        }
        $uri = $uriBuilder->uriFor('listPostsByAuthor', [], 'Post');

        if ($uri !== '') {
            $linkText = $this->renderChildren() ?: $author->getName();
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }

        return $result;
    }
}
