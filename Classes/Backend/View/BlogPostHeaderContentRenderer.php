<?php

declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Backend\View;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class BlogPostHeaderContentRenderer implements SingletonInterface
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function render(ServerRequestInterface $request): string
    {
        $pageUid = (int)($request->getParsedBody()['id'] ?? $request->getQueryParams()['id'] ?? 0);
        $pageInfo = BackendUtility::readPageAccess($pageUid, $GLOBALS['BE_USER']->getPagePermsClause(Permission::PAGE_SHOW));

        // Early exit for non-blog pages
        if (($pageInfo['doktype'] ?? 0) !== Constants::DOKTYPE_BLOG_POST) {
            return '';
        }

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/pagelayout.min.css', 'stylesheet', 'all', '', false);


        $query = $this->postRepository->createQuery();
        $querySettings = $query->getQuerySettings();
        $querySettings->setIgnoreEnableFields(true);
        $this->postRepository->setDefaultQuerySettings($querySettings);
        $post = $this->postRepository->findByUidRespectQuerySettings($pageUid);

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->getRenderingContext()->getTemplatePaths()->fillDefaultsByPackageName('blog');
        $view->setTemplate('PageLayout/Header');
        $view->assignMultiple([
            'pageUid' => $pageUid,
            'pageInfo' => $pageInfo,
            'post' => $post,
        ]);

        $content = $view->render();
        return $content;
    }
}
