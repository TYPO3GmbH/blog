<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    public function __construct()
    {
        $this->tagName = 'img';
        parent::__construct();
    }

    /**
     * Arguments Initialization.
     *
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('alt', 'string', 'Alternative Text for the image');
        $this->registerArgument('email', 'string', 'The email address to resolve the gravatar for', true);
        $this->registerArgument('size', 'int', 'The size of the gravatar, ranging from 1 to 512', false, 65);
        $this->registerArgument('default', 'string', 'The default image for the gravatar, use complete url or one of the default keys');
    }

    /**
     * @return string the HTML <img>-Tag of the gravatar
     */
    public function render(): string
    {
        $size = (int)$this->arguments['size'];
        $default = '';
        if ($this->arguments['default'] !== null) {
            $default = '&d=' . urlencode($this->arguments['default']);
        }
        $url = 'https://www.gravatar.com/avatar/' . md5($this->arguments['email']) . '?s=' . $size . $default;
        $this->tag->addAttribute('src', $url);
        $this->tag->addAttribute('width', $size);
        $this->tag->addAttribute('height', $size);

        return $this->tag->render();
    }
}
