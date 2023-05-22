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
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class BackendController extends ActionController
{
    protected PostRepository $postRepository;
    protected CommentRepository $commentRepository;
    protected ModuleTemplateFactory $moduleTemplateFactory;
    protected PageRenderer $pageRenderer;
    protected SetupService $setupService;
    protected CacheService $cacheService;

    public function __construct(
        PostRepository $postRepository,
        CommentRepository $commentRepository,
        ModuleTemplateFactory $moduleTemplateFactory,
        PageRenderer $pageRenderer,
        SetupService $setupService,
        CacheService $cacheService
    ) {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->moduleTemplateFactory = $moduleTemplateFactory;
        $this->pageRenderer = $pageRenderer;
        $this->setupService = $setupService;
        $this->cacheService = $cacheService;
    }

    public function initializeAction(): void
    {
        $this->pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/Tooltip');
        $this->pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/backend.min.css', 'stylesheet', 'all', '', false);
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
        $this->pageRenderer->loadRequireJsModule('TYPO3/CMS/Blog/Datatables');
        $this->pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/Datatables.min.css', 'stylesheet', 'all', '', false);
    }

    public function setupWizardAction(): ResponseInterface
    {
        return $this->htmlResponse($this->render('Backend/SetupWizard.html', [
            'blogSetups' => $this->setupService->determineBlogSetups(),
        ]));
    }

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

        $response = $this->responseFactory
            ->createResponse()
            ->withHeader('Content-Type', 'text/html; charset=utf-8');
        $response
            ->getBody()
            ->write($html);

        return $response;
    }

    public function commentsAction(string $filter = null, int $blogSetup = null): ResponseInterface
    {
        $comments = [
            'all' => $this->commentRepository->findAllByFilter(null, $blogSetup),
            'pending' => $this->commentRepository->findAllByFilter('pending', $blogSetup),
            'approved' => $this->commentRepository->findAllByFilter('approved', $blogSetup),
            'declined' => $this->commentRepository->findAllByFilter('declined', $blogSetup),
            'deleted' => $this->commentRepository->findAllByFilter('deleted', $blogSetup),
        ];

        $html = $this->render('Backend/Comments.html', [
            'activeFilter' => $filter,
            'activeBlogSetup' => $blogSetup,
            'commentCounts' => [
                'all' => $comments['all']->count(),
                'pending' => $comments['pending']->count(),
                'approved' => $comments['approved']->count(),
                'declined' => $comments['declined']->count(),
                'deleted' => $comments['deleted']->count(),
            ],
            'blogSetups' => $this->setupService->determineBlogSetups(),
            'comments' => $this->commentRepository->findAllByFilter($filter, $blogSetup),
        ]);

        $response = $this->responseFactory
            ->createResponse()
            ->withHeader('Content-Type', 'text/html; charset=utf-8');
        $response
            ->getBody()
            ->write($html);

        return $response;
    }

    public function updateCommentStatusAction(string $status, string $filter = null, int $blogSetup = null, array $comments = [], int $comment = null): void
    {
        if ($comment !== null) {
            $comments['__identity'][] = $comment;
        }
        foreach ($comments['__identity'] as $commentId) {
            /** @var Comment|null $comment */
            $comment = $this->commentRepository->findByUid((int)$commentId);
            if ($comment !== null) {
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
                    $this->cacheService->flushCacheByTag('tx_blog_comment_' . $comment->getUid());
                }
            }
        }
        $this->redirect('comments', null, null, ['filter' => $filter, 'blogSetup' => $blogSetup]);
    }

    public function createBlogAction(array $data = null): void
    {
        if ($data !== null && $this->setupService->createBlogSetup($data)) {
            $this->addFlashMessage('Your blog setup has been created.', 'Congratulation');
        } else {
            $this->addFlashMessage('Sorry, your blog setup could not be created.', 'An error occurred', FlashMessage::ERROR);
        }
        $this->redirect('setupWizard');
    }

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

    protected function render(string $templateNameAndPath, array $values): string
    {
        $view = $this->getFluidTemplateObject($templateNameAndPath);
        $view->assign('_template', $templateNameAndPath);
        $view->assign('action', $this->actionMethodName);
        $view->assignMultiple($values);

        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($view->render());

        return $moduleTemplate->renderContent();
    }
}
