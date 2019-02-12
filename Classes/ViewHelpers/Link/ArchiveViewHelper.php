<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

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
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Class ArchiveViewHelper.
 */
class ArchiveViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * ArchiveViewHelper constructor.
     */
    public function __construct()
    {
        $this->tagName = 'a';
        parent::__construct();
    }

    /**
     * Arguments initialization.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
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

    /**
     * @return string Rendered page URI
     */
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
        $uriBuilder = $this->renderingContext->getControllerContext()->getUriBuilder();
        $uriBuilder->reset()
            ->setTargetPageUid($pageUid)
            ->setUseCacheHash(true);
        if ($rssFormat) {
            $uriBuilder
                ->setFormat('rss')
                ->setTargetPageType($this->getTypoScriptFrontendController()->tmpl->setup['blog_rss_archive.']['typeNum']);
        }
        $uri = $uriBuilder->uriFor('listPostsByDate', $arguments, 'Post', 'Blog', 'Archive');
        if ($uri !== '') {
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($this->renderChildren());
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }

        return $result;
    }

    /**
     * @return mixed|\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
