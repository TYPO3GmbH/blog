<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link\Be;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class PostViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('post', Post::class, 'The post to link to', true);
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
        $this->registerArgument('action', 'string', 'action to link', false, null);
    }

    public function render(): string
    {
        $request = $this->getRequest();
        if (!$request instanceof ServerRequestInterface) {
            throw new \RuntimeException(
                'ViewHelper blogvh:link.be.post needs a request implementing ServerRequestInterface.',
                1684305293
            );
        }

        /** @var Post $post */
        $post = $this->arguments['post'];
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);

        switch ($this->arguments['action']) {
            case 'edit':
                $uri = (string)$uriBuilder->buildUriFromRoute('record_edit', [
                    'edit' => ['pages' => [$post->getUid() => 'edit']],
                    'returnUrl' => $request->getAttribute('normalizedParams')->getRequestUri(),
                ]);
                break;
            default:
                $uri = (string)$uriBuilder->buildUriFromRoute('web_layout', [
                    'id' => $post->getUid(),
                ]);
                break;
        }

        if (isset($this->arguments['returnUri']) && $this->arguments['returnUri'] === true) {
            return htmlspecialchars($uri, ENT_QUOTES | ENT_HTML5);
        }

        $linkText = $this->renderChildren() ?? ($post->getTitle() !== '' ? $post->getTitle() : LocalizationUtility::translate('backend.message.nopost', 'blog'));
        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($linkText);

        return $this->tag->render();
    }

    protected function getRequest(): ?ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'] ?? null;
    }
}
