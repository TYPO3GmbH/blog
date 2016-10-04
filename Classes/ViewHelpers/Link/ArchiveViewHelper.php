<?php

namespace T3G\AgencyPack\Blog\ViewHelpers\Link;

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
 * Class ArchiveViewHelper.
 */
class ArchiveViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * Arguments initialization
     *
     * @return void
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link', false);
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document', false);

        $this->registerArgument('month', 'int', 'The month to link to');
        $this->registerArgument('year', 'int', 'The year to link to', true);
        $this->registerArgument('rss', 'bool', 'Link to rss version', false, false);
    }

    /**
     * @return string Rendered page URI
     */
    public function render()
    {
        $rssFormat = (bool)$this->arguments['rss'];
        $year = (int)$this->arguments['year'];
        $month = (int)$this->arguments['month'];
        $pageUid = (int)$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_blog.']['settings.']['archiveUid'];
        $additionalParams = [
            'tx_blog_archive' => [
                'year' => $year
            ]
        ];
        if ($month > 0) {
            $additionalParams['tx_blog_archive']['month'] = $month;
        }
        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset()
            ->setTargetPageUid($pageUid)
            ->setUseCacheHash(false)
            ->setArguments($additionalParams);
        if ($rssFormat) {
            $uriBuilder
                ->setFormat('rss')
                ->setTargetPageType($GLOBALS['TSFE']->tmpl->setup['blog_rss_archive.']['typeNum']);
        }
        $uri = $uriBuilder->uriFor('listPostsByDate', [], 'Post');
        if ((string)$uri !== '') {
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($this->renderChildren());
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }
        return $result;
    }
}
