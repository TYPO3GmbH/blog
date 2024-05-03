<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Link;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class ArchiveViewHelper extends AbstractTagBasedViewHelper
{
    public function __construct()
    {
        $this->tagName = 'a';
        parent::__construct();
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');

        $this->registerArgument('month', 'int', 'The month to link to');
        $this->registerArgument('year', 'int', 'The year to link to', true);
        $this->registerArgument('rss', 'bool', 'Link to rss version', false, false);
    }

    public function render(): string
    {
        $rssFormat = (bool)$this->arguments['rss'];
        $year = (int)$this->arguments['year'];
        $month = (int)$this->arguments['month'];
        $pageUid = (int)$this->getTypoScriptFrontendController()->tmpl->setup['plugin.']['tx_blog.']['settings.']['archiveUid'];
        $arguments = [
            'year' => $year
        ];
        if ($month > 0) {
            $arguments['month'] = $month;
        }
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uriBuilder->reset()
            ->setTargetPageUid($pageUid);
        if ($rssFormat) {
            $uriBuilder
                ->setTargetPageType((int)$this->getTypoScriptFrontendController()->tmpl->setup['blog_rss_archive.']['typeNum']);
        }
        $uri = $uriBuilder->uriFor('listPostsByDate', $arguments, 'Post', 'Blog', 'Archive');
        $linkText = $this->renderChildren() ?? implode('-', $arguments);
        if ($uri !== '') {
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($linkText);
            $result = $this->tag->render();
        } else {
            $result = $linkText;
        }

        return (string)$result;
    }

    protected function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
