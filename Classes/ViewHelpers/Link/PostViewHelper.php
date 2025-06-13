<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class PostViewHelper extends AbstractTagBasedViewHelper
{
    public function __construct()
    {
        $this->tagName = 'a';
        parent::__construct();
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('post', Post::class, 'The post to link to');
        $this->registerArgument('section', 'string', 'the anchor to be added to the URI');
        $this->registerArgument('createAbsoluteUri', 'bool', 'create absolute uri', false, false);
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
    }

    public function render(): string
    {
        /** @var Post $post */
        $post = $this->arguments['post'];
        $section = $this->arguments['section'] ?? '';
        $pageUid = (int) $post->getUid();
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $createAbsoluteUri = (bool)$this->arguments['createAbsoluteUri'];
        $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        $uri = $uriBuilder->reset()
            ->setRequest($request)
            ->setTargetPageUid($pageUid)
            ->setSection($section)
            ->setCreateAbsoluteUri($createAbsoluteUri)
            ->build();
        if ($uri !== '') {
            if (isset($this->arguments['returnUri']) && $this->arguments['returnUri'] === true) {
                return htmlspecialchars($uri, ENT_QUOTES | ENT_HTML5);
            }
            $linkText = $this->renderChildren() ?? $post->getTitle();
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }

        return $result;
    }
}
