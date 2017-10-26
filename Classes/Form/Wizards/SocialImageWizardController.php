<?php

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
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use TYPO3\CMS\Backend\Module\AbstractModule;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class SocialImageWizardController
 *
 * @package T3G\AgencyPack\Blog\Form\Wizards
 */
class SocialImageWizardController extends AbstractModule
{

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
        parent::__construct();
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplatePathAndFilename('EXT:blog/Resources/Private/Templates/Backend/SocialImageWizard.html');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $postData = $this->getPageData();
        $this->view->assign('postData', $postData);
        $this->view->assign('dataSourceFilter', $this->getDataSource('filter', $request));
        $this->view->assign('dataSourceSkin', $this->getDataSource('skin', $request));
        $this->moduleTemplate->setContent($this->view->render());
        $this->moduleTemplate->getPageRenderer()->addCssFile('EXT:blog/Resources/Public/Css/SocialImageWizard.css');
        $this->moduleTemplate->getPageRenderer()->loadJquery();
        $this->moduleTemplate->getPageRenderer()->addJsFile('EXT:blog/Resources/Public/JavaScript/fabric.min.js');
        $this->moduleTemplate->getPageRenderer()->addJsFile('EXT:blog/Resources/Public/JavaScript/SocialImageApp.js');
        $response->getBody()->write($this->moduleTemplate->renderContent());
        return $response;
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function getPageData(): array
    {
        $post = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(PostRepository::class)
            ->findCurrentPost();

        $socialData = [
            'author' => $post->getAuthors()->current()->getName(),
            'image' => $post->getMedia()->current()->getOriginalResource()->getPublicUrl(),
            'title' => $post->getTitle(),
            'uid' => $post->getUid(),
            'table' => 'pages'
        ];

        return $socialData;
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
