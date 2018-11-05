<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Form\Wizards;

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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class SocialImageWizardController
 *
 */
class SocialImageWizardController
{
    /**
     * @var ModuleTemplate
     */
    protected $moduleTemplate;

    /**
     * @var StandaloneView
     */
    protected $view;

    /**
     * SocialImageWizardController constructor.
     *
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplatePathAndFilename('EXT:blog/Resources/Private/Templates/Backend/SocialImageWizard.html');
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $postData = $this->getPageData();
        $this->view->assign('postData', $postData);
        $this->view->assign('dataSourceFilter', $this->getDataSource('filter', $request));
        $this->view->assign('dataSourceSkin', $this->getDataSource('skin', $request));
        $this->moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $this->moduleTemplate->setContent($this->view->render());
        $pageRenderer = $this->moduleTemplate->getPageRenderer();
        $pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/SocialImageWizard.css');
        $pageRenderer->addJsFile('EXT:blog/Resources/Public/JavaScript/fabric.min.js');
        $pageRenderer->addJsFile('EXT:blog/Resources/Public/JavaScript/SocialImageApp.js');
        return GeneralUtility::makeInstance(HtmlResponse::class, $this->moduleTemplate->renderContent());
    }

    /**
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    protected function getPageData(): array
    {
        $post = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(PostRepository::class)
            ->findCurrentPost();

        return $post instanceof Post ? [
            'author' => $post->getAuthors()->current()->getName(),
            'image' => $post->getMedia()->current()->getOriginalResource()->getPublicUrl(),
            'title' => $post->getTitle(),
            'uid' => $post->getUid(),
            'table' => 'pages'
        ] : [];
    }

    /**
     * @param string $type
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    protected function getDataSource(string $type, ServerRequestInterface $request): string
    {
        $pageTsConfig = BackendUtility::getPagesTSconfig((int)$request->getQueryParams()['id']);
        $path = $pageTsConfig['mod.']['SocialImageWizard.']['dataSource.'][$type]
            ?? 'EXT:blog/Resources/Public/JavaScript/' . ucfirst($type) . '/Default.json';
        return PathUtility::getAbsoluteWebPath(GeneralUtility::getFileAbsFileName($path));
    }
}
