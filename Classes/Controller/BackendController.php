<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Controller;

use Psr\Http\Message\ResponseInterface;
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Service\SetupService;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Fluid\View\StandaloneView;

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
     * @var CacheService
     */
    protected $blogCacheService;
    private \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer;
    public function __construct(\TYPO3\CMS\Core\Imaging\IconFactory $iconFactory, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer)
    {
        $this->iconFactory = $iconFactory;
        $this->pageRenderer = $pageRenderer;
    }

    /**
     * @param SetupService $setupService
     */
    public function injectSetupService(SetupService $setupService): void
    {
        $this->setupService = $setupService;
    }

    /**
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository): void
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param CommentRepository $commentRepository
     */
    public function injectCommentRepository(CommentRepository $commentRepository): void
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param \T3G\AgencyPack\Blog\Service\CacheService $cacheService
     */
    public function injectBlogCacheService(CacheService $cacheService): void
    {
        $this->blogCacheService = $cacheService;
    }

    public function initializeAction(): void
    {
        $this->moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $this->iconFactory = $this->iconFactory;
        $this->buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();

        $pageRenderer = $this->pageRenderer;
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/Tooltip');
        $pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/backend.min.css', 'stylesheet', 'all', '', false);
    }

    public function initializeSetupWizardAction(): void
    {
        $this->initializeDataTables();
        $this->pageRenderer->loadRequireJsModule('TYPO3/CMS/Blog/SetupWizard');
    }

    public function initializePostsAction(): void
    {
        $this->initializeDataTables();
    }

    public function initializeCommentsAction(): void
    {
        $this->initializeDataTables();
        $this->pageRenderer->loadRequireJsModule('TYPO3/CMS/Blog/MassUpdate');
    }

    protected function initializeDataTables(): void
    {
        $pageRenderer = $this->pageRenderer;
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Blog/Datatables');
        $pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/Datatables.min.css', 'stylesheet', 'all', '', false);
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
    public function setupWizardAction(): ResponseInterface
    {
        return $this->htmlResponse($this->render('Backend/SetupWizard.html', [
            'blogSetups' => $this->setupService->determineBlogSetups(),
        ]));
    }

    /**
     * @param int $blogSetup
     * @return string
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function postsAction(int $blogSetup = null): ResponseInterface
    {
        $query = $this->postRepository->createQuery();
        $querySettings = $query->getQuerySettings();
        $querySettings->setIgnoreEnableFields(true);
        $this->postRepository->setDefaultQuerySettings($querySettings);

        $html = $this->render('Backend/Posts.html', [
            'blogSetups' => $this->setupService->determineBlogSetups(),
            'activeBlogSetup' => $blogSetup,
            'posts' => $this->postRepository->findAllByPid($blogSetup),
        ]);
        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/html; charset=utf-8');
        $response->getBody()->write($html ?? $this->view->render());
        return $response;
    }

    /**
     * @param string $filter
     * @param int $blogSetup
     *
     * @return string
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \InvalidArgumentException
     */
    public function commentsAction(string $filter = null, int $blogSetup = null): ResponseInterface
    {
        $html = $this->render('Backend/Comments.html', [
            'activeFilter' => $filter,
            'activeBlogSetup' => $blogSetup,
            'commentCounts' => [
                'all' => $this->commentRepository->findAllByFilter(null, $blogSetup)->count(),
                'pending' => $this->commentRepository->findAllByFilter('pending', $blogSetup)->count(),
                'approved' => $this->commentRepository->findAllByFilter('approved', $blogSetup)->count(),
                'declined' => $this->commentRepository->findAllByFilter('declined', $blogSetup)->count(),
                'deleted' => $this->commentRepository->findAllByFilter('deleted', $blogSetup)->count(),
            ],
            'blogSetups' => $this->setupService->determineBlogSetups(),
            'comments' => $this->commentRepository->findAllByFilter($filter, $blogSetup),
        ]);
        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/html; charset=utf-8');
        $response->getBody()->write($html ?? $this->view->render());
        return $response;
    }

    /**
     * @param string $status
     * @param string $filter
     * @param int $blogSetup
     * @param array $comments
     * @param int $comment
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateCommentStatusAction(string $status, string $filter = null, int $blogSetup = null, array $comments = [], int $comment = null): void
    {
        if ($comment !== null) {
            $comments['__identity'][] = $comment;
        }
        foreach ($comments['__identity'] as $commentId) {
            $comment = $this->commentRepository->findByUid((int)$commentId);
            $updateComment = true;
            switch ($status) {
                case 'approve':
                    $comment->setStatus(Comment::STATUS_APPROVED);
                    break;
                case 'decline':
                    $comment->setStatus(Comment::STATUS_DECLINED);
                    break;
                case 'delete':
                    $comment->setStatus(Comment::STATUS_DELETED);
                    break;
                default:
                    $updateComment = false;
            }
            if ($updateComment) {
                $this->commentRepository->update($comment);
                $this->blogCacheService->flushCacheByTag('tx_blog_comment_' . $comment->getUid());
            }
        }
        $this->redirect('comments', null, null, ['filter' => $filter, 'blogSetup' => $blogSetup]);
    }

    /**
     * @param array $data
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException
     */
    public function createBlogAction(array $data = null): void
    {
        if ($this->setupService->createBlogSetup($data)) {
            $this->addFlashMessage('Your blog setup has been created.', 'Congratulation');
        } else {
            $this->addFlashMessage('Sorry, your blog setup could not be created.', 'An error occurred', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
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
    protected function getFluidTemplateObject(string $templateNameAndPath): StandaloneView
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setLayoutRootPaths([GeneralUtility::getFileAbsFileName('EXT:blog/Resources/Private/Layouts')]);
        $view->setPartialRootPaths([GeneralUtility::getFileAbsFileName('EXT:blog/Resources/Private/Partials')]);
        $view->setTemplateRootPaths([GeneralUtility::getFileAbsFileName('EXT:blog/Resources/Private/Templates')]);
        $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:blog/Resources/Private/Templates/' . $templateNameAndPath));
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
    protected function render(string $templateNameAndPath, array $values): string
    {
        $view = $this->getFluidTemplateObject($templateNameAndPath);
        $view->assign('_template', $templateNameAndPath);
        $view->assign('action', $this->actionMethodName);
        $view->assignMultiple($values);
        $this->moduleTemplate->setContent($view->render());

        return $this->moduleTemplate->renderContent();
    }
}
