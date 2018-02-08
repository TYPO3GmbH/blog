<?php

namespace T3G\AgencyPack\Blog\ViewHelpers\Link\Be;

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
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class TagViewHelper.
 */
class TagViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * PostViewHelper constructor.
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
        $this->registerTagAttribute('itemprop', 'string', 'itemprop attribute');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');

        $this->registerArgument('tag', Tag::class, 'The tag to link to');
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
    }

    /**
     * @return string Rendered page URI
     *
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     * @throws \InvalidArgumentException
     */
    public function render()
    {
        /** @var Tag $tag */
        $tag = $this->arguments['tag'];
        $tagUid = $tag !== null ? (int) $tag->getUid() : 0;

        $routingUriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uri = $routingUriBuilder->buildUriFromRoute('record_edit', array('edit[tx_blog_domain_model_tag]['.$tagUid.']' => 'edit'));
        $arguments = GeneralUtility::_GET();
        unset($arguments['M'], $arguments['moduleToken']);
        $uri .= '&returnUrl='.rawurlencode(BackendUtility::getModuleUrl(GeneralUtility::_GET('M'), $arguments));
        if ($uri !== '') {
            if ($this->arguments['returnUri']) {
                return $uri;
            }
            $linkText = $this->renderChildren() ?: $tag->getTitle();
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }

        return $result;
    }
}
