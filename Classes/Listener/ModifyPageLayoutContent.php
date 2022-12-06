<?php

declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Listener;

use T3G\AgencyPack\Blog\Backend\View\BlogPostHeaderContentRenderer;
use TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ModifyPageLayoutContent
{
    protected BlogPostHeaderContentRenderer $blogPostHeaderContentRenderer;

    public function __construct(BlogPostHeaderContentRenderer $blogPostHeaderContentRenderer)
    {
        $this->blogPostHeaderContentRenderer = $blogPostHeaderContentRenderer;
    }

    public function __invoke(ModifyPageLayoutContentEvent $e)
    {
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $blogConfiguration = $extensionConfiguration->get('blog');
        if ((bool)($blogConfiguration['disablePageLayoutHeader']) ?? true) {
            return;
        }
        $request = $e->getRequest();
        $content = $this->blogPostHeaderContentRenderer->render($request);
        $e->addHeaderContent($content);
    }
}
