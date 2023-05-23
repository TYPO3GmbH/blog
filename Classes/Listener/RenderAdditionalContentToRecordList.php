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
use TYPO3\CMS\Backend\Controller\Event\RenderAdditionalContentToRecordListEvent;

class RenderAdditionalContentToRecordList
{
    protected BlogPostHeaderContentRenderer $blogPostHeaderContentRenderer;

    public function __construct(BlogPostHeaderContentRenderer $blogPostHeaderContentRenderer)
    {
        $this->blogPostHeaderContentRenderer = $blogPostHeaderContentRenderer;
    }

    /**
     * @return void
     */
    public function __invoke(RenderAdditionalContentToRecordListEvent $event)
    {
        $request = $event->getRequest();
        $content = $this->blogPostHeaderContentRenderer->render($request);
        $event->addContentAbove($content);
    }
}
