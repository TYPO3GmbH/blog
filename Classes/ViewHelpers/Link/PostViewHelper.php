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
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class PostViewHelper.
 */
class PostViewHelper extends AbstractTagBasedViewHelper
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

        $this->registerArgument('post', Post::class, 'The post to link to');
        $this->registerArgument('section', 'string', 'the anchor to be added to the URI');
        $this->registerArgument('createAbsoluteUri', 'bool', 'create absolute uri', false, false);
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
    }

    /**
     * @return string Rendered page URI
     */
    public function render()
    {
        /** @var Post $post */
        $post = $this->arguments['post'];
        $section = $this->arguments['section'] ?: null;
        $pageUid = $post !== null ? (int)$post->getUid() : 0;
        $uriBuilder = $this->controllerContext->getUriBuilder();
        $createAbsoluteUri = (bool)$this->arguments['createAbsoluteUri'];
        $uri = $uriBuilder->reset()
            ->setTargetPageUid($pageUid)
            ->setUseCacheHash(false)
            ->setSection($section)
            ->setCreateAbsoluteUri($createAbsoluteUri)
            ->build();
        if ((string)$uri !== '') {
            if ($this->arguments['returnUri']) {
                return $uri;
            }
            $linkText = $this->renderChildren() ?: $post->getTitle();
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }
        return $result;
    }
}
