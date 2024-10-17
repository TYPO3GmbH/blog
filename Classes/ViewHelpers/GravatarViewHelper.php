<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers;

use T3G\AgencyPack\Blog\AvatarProvider\GravatarProvider;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    public function __construct()
    {
        $this->tagName = 'img';
        parent::__construct();
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('email', 'string', 'The email address to resolve the gravatar for', true);
        $this->registerArgument('size', 'int', 'The size of the gravatar, ranging from 1 to 512', false, 64);
    }

    public function render(): string
    {
        $author = (new Author())->setEmail($this->arguments['email']);
        $size = (int)$this->arguments['size'];

        /** @var GravatarProvider $gravatarProvider */
        $gravatarProvider = GeneralUtility::makeInstance(GravatarProvider::class);
        $src = $gravatarProvider->getAvatarUrl($author, $size);

        $this->tag->addAttribute('src', (string) $src);
        $this->tag->addAttribute('width', (string) $size);
        $this->tag->addAttribute('height', (string) $size);

        return $this->tag->render();
    }
}
