<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Hooks;

use T3G\AgencyPack\Blog\Backend\View\BlogPostHeaderContentRenderer;

class PageLayoutHeaderHook
{
    protected BlogPostHeaderContentRenderer $blogPostHeaderContentRenderer;

    public function __construct(BlogPostHeaderContentRenderer $blogPostHeaderContentRenderer)
    {
        $this->blogPostHeaderContentRenderer = $blogPostHeaderContentRenderer;
    }

    /**
     * @return string
     */
    public function drawHeader()
    {
        $request = $GLOBALS['TYPO3_REQUEST'];
        return $this->blogPostHeaderContentRenderer->render($request);
    }
}
