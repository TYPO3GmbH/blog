<?php

namespace T3G\AgencyPack\Blog\ViewHelpers;

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
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class GravatarViewHelper.
 */
class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * GravatarViewHelper constructor.
     */
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
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('alt', 'string', 'Alternative Text for the image');
        $this->registerArgument('email', 'string', 'The email address to resolve the gravatar for', true);
        $this->registerArgument('size', 'int', 'The size of the gravatar, ranging from 1 to 512', false, 65);
        $this->registerArgument('default', 'string', 'The default image for the gravatar, use complete url or one of the default keys');
    }

    /**
     * @return string the HTML <img>-Tag of the gravatar
     */
    public function render()
    {
        $size = (int) $this->arguments['size'];
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
