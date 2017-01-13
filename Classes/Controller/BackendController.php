<?php

namespace T3G\AgencyPack\Blog\Controller;

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

use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\SetupService;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class BackendController.
 */
class BackendController extends ActionController
{
    /**
     * @var ModuleTemplate
     */
    protected $moduleTemplate;

    /**
     * @var IconFactory
     */
    protected $iconFactory;

    /**
     * @var ButtonBar
     */
    protected $buttonBar;

    /**
     * @var SetupService
     */
    protected $setupService;

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var CommentRepository
     */
    protected $commentRepository;

    /**
     * @param SetupService $setupService
     */
    public function injectSetupService(SetupService $setupService)
    {
        $this->setupService = $setupService;
    }

    /**
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param CommentRepository $commentRepository
     */
    public function injectCommentRepository(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \BadFunctionCallException
     */
    public function initializeAction()
    {
        $this->moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $this->iconFactory = $this->moduleTemplate->getIconFactory();
        $this->buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();

        $pageRenderer = $this->moduleTemplate->getPageRenderer();
        $pageRenderer->addCssFile('../typo3conf/ext/blog/Resources/Public/Css/bootstrap.min.css', 'stylesheet', 'all', '', false);
        $pageRenderer->addCssFile('../typo3conf/ext/blog/Resources/Public/Css/backend.css', 'stylesheet', 'all', '', false);
    }

    /**
     *
     */
    public function initializeSetupWizardAction()
    {
        $this->moduleTemplate->getPageRenderer()->loadRequireJsModule('TYPO3/CMS/Blog/SetupWizard');
    }

    /**
     *
     * @throws \BadFunctionCallException
     */
    public function initializePostsAction()
    {
        $blogPath = ExtensionManagementUtility::extPath('blog', 'Resources/Public/JavaScript/');
        $blogPath = PathUtility::getAbsoluteWebPath($blogPath);
        $pageRenderer = $this->moduleTemplate->getPageRenderer();
        $pageRenderer->addRequireJsConfiguration([
            'paths' => [
                'datatables_bootstrap' => $blogPath . 'dataTables.bootstrap.min'
            ],
            'map' => [
                '*' => [
                    'datatables.net' => 'datatables',
                ]
            ]
        ]);
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Blog/DataTables');
        $pageRenderer->addCssFile('../typo3conf/ext/blog/Resources/Public/Css/dataTables.bootstrap.min.css', 'stylesheet', 'all', '', false);   
    }

    /**
     * Render the start page.
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     *
     * @return string
     *
     * @throws \BadFunctionCallException
     */
    public function setupWizardAction()
    {
        return $this->render('Backend/SetupWizard.html', [
            'blogSetups' => $this->setupService->determineBlogSetups(),
            'templateExists' => ExtensionManagementUtility::isLoaded('blog_template'),
        ]);
    }

    /**
     * @param int    $blogSetup
     * @return string
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \InvalidArgumentException
     */
    public function postsAction($blogSetup = null)
    {
        return $this->render('Backend/Posts.html', [
            'blogSetups' => $this->setupService->determineBlogSetups(),
            'activeBlogSetup' => $blogSetup,
            'posts' => $this->postRepository->findAll($blogSetup),
        ]);
    }

    /**
     * @param string $filter
     * @param int    $blogSetup
     *
     * @return string
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \InvalidArgumentException
     */
    public function commentsAction($filter = null, $blogSetup = null)
    {
        return $this->render('Backend/Comments.html', [
            'activeFilter' => $filter,
            'activeBlogSetup' => $blogSetup,
            'commentCounts' => [
                'all' => $this->commentRepository->findAllByFilter(null, $blogSetup)->count(),
                'pending' => $this->commentRepository->findAllByFilter('pending', $blogSetup)->count(),
                'approved' => $this->commentRepository->findAllByFilter('approved', $blogSetup)->count(),
                'deleted' => $this->commentRepository->findAllByFilter('deleted', $blogSetup)->count(),
            ],
            'blogSetups' => $this->setupService->determineBlogSetups(),
            'comments' => $this->commentRepository->findAllByFilter($filter, $blogSetup),
        ]);
    }

    /**
     * @param array $data
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \RuntimeException
     */
    public function createBlogAction(array $data = null)
    {
        if ($this->setupService->createBlogSetup($data)) {
            $this->addFlashMessage('Your blog setup has been created.', 'Congratulation');
        } else {
            $this->addFlashMessage('Sorry, your blog setup could not be created.', 'An error occurred', FlashMessage::ERROR);
        }
        $this->redirect('setupWizard');
    }

    /**
     * returns a new standalone view, shorthand function.
     *
     * @param string $templateNameAndPath
     *
     * @return StandaloneView
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \InvalidArgumentException
     */
    protected function getFluidTemplateObject($templateNameAndPath)
    {
        /** @var StandaloneView $view */
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setLayoutRootPaths([GeneralUtility::getFileAbsFileName('EXT:blog/Resources/Private/Layouts')]);
        $view->setPartialRootPaths([GeneralUtility::getFileAbsFileName('EXT:blog/Resources/Private/Partials')]);
        $view->setTemplateRootPaths([GeneralUtility::getFileAbsFileName('EXT:blog/Resources/Private/Templates')]);
        $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:blog/Resources/Private/Templates/'.$templateNameAndPath));
        $view->setControllerContext($this->getControllerContext());
        $view->getRequest()->setControllerExtensionName('Blog');

        return $view;
    }

    /**
     * @param string $templateNameAndPath
     * @param array  $values
     *
     * @return string
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \InvalidArgumentException
     */
    protected function render($templateNameAndPath, array $values)
    {
        $view = $this->getFluidTemplateObject($templateNameAndPath);
        $view->assign('_template', $templateNameAndPath);
        $view->assign('action', $this->actionMethodName);
        $view->assignMultiple($values);
        $this->moduleTemplate->setContent($view->render());

        return $this->moduleTemplate->renderContent();
    }
}
