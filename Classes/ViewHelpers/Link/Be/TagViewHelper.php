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
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class TagViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('tag', Tag::class, 'The tag to link to', true);
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
    }

    public function render(): string
    {
        $request = $this->getRequest();
        if (!$request instanceof ServerRequestInterface) {
            throw new \RuntimeException(
                'ViewHelper blogvh:link.be.tag needs a request implementing ServerRequestInterface.',
                1684305294
            );
        }

        /** @var Tag $tag */
        $tag = $this->arguments['tag'];
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);

        $params = [
            'edit' => ['tx_blog_domain_model_tag' => [$tag->getUid() => 'edit']],
            'returnUrl' => $request->getAttribute('normalizedParams')->getRequestUri(),
        ];
        $uri = (string)$uriBuilder->buildUriFromRoute('record_edit', $params);
        if (isset($this->arguments['returnUri']) && $this->arguments['returnUri'] === true) {
            return htmlspecialchars($uri, ENT_QUOTES | ENT_HTML5);
        }

        $linkText = $this->renderChildren() ?? $tag->getTitle();
        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($linkText);

        return $this->tag->render();
    }

    protected function getRequest(): ?ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'] ?? null;
    }
}
