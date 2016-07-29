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
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class TagViewHelper.
 */
class TagViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * Arguments initialization
     *
     * @return void
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link', false);
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document', false);

        $this->registerArgument('tag', Tag::class, 'The tag to link to', true);
    }

    /**
     * @return string Rendered page URI
     */
    public function render()
    {
        /** @var Tag $tag */
        $tag = $this->arguments['tag'];
        $pageUid = (int)$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_blog.']['settings.']['tagUid'];
        $additionalParams = [
            'tx_blog_tag' => [
                'tag' => $tag->getUid()
            ]
        ];
        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uri = $uriBuilder->reset()
            ->setTargetPageUid($pageUid)
            ->setUseCacheHash(false)
            ->setArguments($additionalParams)
            ->build();
        if ((string)$uri !== '') {
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
