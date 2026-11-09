<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link\Socials;

use T3G\AgencyPack\Blog\Utility\Socials\MastodonUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class MastodonViewHelper extends AbstractTagBasedViewHelper
{
    public function __construct()
    {
        $this->tagName = 'a';
        parent::__construct();
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('mastodon', 'string', 'The mastodon handle or URL', true);
        $this->registerArgument('returnUri', 'bool', 'Return only uri', false, false);
    }

    public function render(): string
    {
        $uri = MastodonUtility::getMastodonUrl($this->arguments['mastodon']);
        if ($uri !== '') {
            if (isset($this->arguments['returnUri']) && $this->arguments['returnUri'] === true) {
                return htmlspecialchars($uri, ENT_QUOTES | ENT_HTML5);
            }
            $linkText = $this->renderChildren() ?? MastodonUtility::getMastodonHandle($this->arguments['mastodon']);
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }

        return (string)$result;
    }
}
