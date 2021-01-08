<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link;

use T3G\AgencyPack\Blog\Domain\Model\Post;
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
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link');
        $this->registerTagAttribute('itemprop', 'string', 'itemprop attribute');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');

        $this->registerArgument('post', Post::class, 'The post to link to');
        $this->registerArgument('section', 'string', 'the anchor to be added to the URI');
        $this->registerArgument('createAbsoluteUri', 'bool', 'create absolute uri', false, false);
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
    }

    /**
     * @return string Rendered page URI
     */
    public function render(): string
    {
        /** @var Post $post */
        $post = $this->arguments['post'];
        $section = $this->arguments['section'] ?: '';
        $pageUid = (int) $post->getUid();
        $uriBuilder = $this->renderingContext->getControllerContext()->getUriBuilder();
        $createAbsoluteUri = (bool)$this->arguments['createAbsoluteUri'];
        $uri = $uriBuilder->reset()
            ->setTargetPageUid($pageUid)
            ->setSection($section)
            ->setCreateAbsoluteUri($createAbsoluteUri)
            ->build();
        if ($uri !== '') {
            if ($this->arguments['returnUri']) {
                return htmlspecialchars($uri, ENT_QUOTES | ENT_HTML5);
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
