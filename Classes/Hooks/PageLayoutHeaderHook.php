<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Hooks;

use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

class PageLayoutHeaderHook
{
    /**
     * @return string
     */
    public function drawHeader()
    {
        $request = $GLOBALS['TYPO3_REQUEST'];
        $pageUid = (int)($request->getParsedBody()['id'] ?? $request->getQueryParams()['id'] ?? 0);
        $pageInfo = BackendUtility::readPageAccess($pageUid, $GLOBALS['BE_USER']->getPagePermsClause(Permission::PAGE_SHOW));

        // Early exit for non-blog pages
        if ($pageInfo['doktype'] !== Constants::DOKTYPE_BLOG_POST) {
            return '';
        }

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/pagelayout.min.css', 'stylesheet', 'all', '', false);

        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $repository = $objectManager->get(PostRepository::class);
        $query = $repository->createQuery();
        $querySettings = $query->getQuerySettings();
        $querySettings->setIgnoreEnableFields(true);
        $repository->setDefaultQuerySettings($querySettings);
        $post = $repository->findByUidRespectQuerySettings($pageUid);

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->getRenderingContext()->getTemplatePaths()->fillDefaultsByPackageName('blog');
        $view->setTemplate('PageLayout/Header');
        $view->assignMultiple([
            'pageUid' => $pageUid,
            'pageInfo' => $pageInfo,
            'post' => $post,
        ]);

        return $view->render();
    }
}
