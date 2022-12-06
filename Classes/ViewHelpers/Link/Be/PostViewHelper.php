<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link\Be;

use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class PostViewHelper extends AbstractTagBasedViewHelper
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

        $this->registerArgument('post', Post::class, 'The post to link to');
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
        $this->registerArgument('action', 'string', 'action to link', false, null);
    }

    /**
     * @return string
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public function render(): string
    {
        /** @var Post $post */
        $post = $this->arguments['post'];
        $pageUid = (int)$post->getUid();

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        switch ($this->arguments['action']) {
            case 'edit':
                $uri = (string)$uriBuilder->buildUriFromRoute('record_edit', ['edit[pages][' . $pageUid . ']' => 'edit']);
                $route = '/module/web/list';
                break;
            case 'show':
            default:
                $uri = (string)$uriBuilder->buildUriFromRoute('web_layout', ['id' => $pageUid]);
                $route = '/module/web/layout';
                break;
        }

        $arguments = GeneralUtility::_GET();
        unset($arguments['route'], $arguments['token']);
        $uri .= '&returnUrl=' . rawurlencode((string)GeneralUtility::makeInstance(UriBuilder::class)->buildUriFromRoutePath($route, $arguments));

        if ($uri !== '') {
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
