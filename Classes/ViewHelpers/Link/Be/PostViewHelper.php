<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

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
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class PostViewHelper.
 */
class PostViewHelper extends AbstractTagBasedViewHelper
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
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link', false);
        $this->registerTagAttribute('itemprop', 'string', 'itemprop attribute', false);
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document', false);

        $this->registerArgument('post', Post::class, 'The post to link to');
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
    }

    /**
     * @return string Rendered page URI
     *
     * @throws \InvalidArgumentException
     */
    public function render()
    {
        /** @var Post $post */
        $post = $this->arguments['post'];
        $pageUid = $post !== null ? (int) $post->getUid() : 0;

        $uri = BackendUtility::getModuleUrl('web_layout', ['id' => $pageUid]);
        if ((string) $uri !== '') {
            if ($this->arguments['returnUri']) {
                return $uri;
            }
            $title = $post !== null ? $post->getTitle() : LocalizationUtility::translate('backend.message.nopost', 'blog');
            $linkText = $this->renderChildren() ?: $title;
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }

        return $result;
    }
}
