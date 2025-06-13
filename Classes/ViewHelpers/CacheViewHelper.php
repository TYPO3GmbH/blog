<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Service\CacheService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class CacheViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('post', Post::class, 'the post to tag', true);
    }

    public function render(): string
    {
        $post = $this->arguments['post'];
        $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        GeneralUtility::makeInstance(CacheService::class)->addTagsForPost($request, $post);

        return '';
    }
}
