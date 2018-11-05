<?php
declare(strict_types = 1);

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
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class CommentViewHelper.
 */
class CommentViewHelper extends AbstractTagBasedViewHelper
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
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link');
        $this->registerTagAttribute('itemprop', 'string', 'itemprop attribute');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');

        $this->registerArgument('comment', Comment::class, 'The comment to link to');
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
        /** @var Comment $comment */
        $comment = $this->arguments['comment'];
        $commentUid = $comment !== null ? (int)$comment->getUid() : 0;

        $routingUriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uri = $routingUriBuilder->buildUriFromRoute('record_edit', ['edit[tx_blog_domain_model_comment][' . $commentUid . ']' => 'edit']);
        $arguments = GeneralUtility::_GET();
        $route = $arguments['route'];
        unset($arguments['route'], $arguments['token']);
        $uri .= '&returnUrl=' . rawurlencode((string)GeneralUtility::makeInstance(UriBuilder::class)->buildUriFromRoutePath($route, $arguments));
        if ($uri !== '') {
            if ($this->arguments['returnUri']) {
                return $uri;
            }
            $linkText = $this->renderChildren() ?: $comment->getComment();
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }

        return $result;
    }
}
