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
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

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
        $this->pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/backend.min.css', 'stylesheet', 'all', '', false);
    }

    public function initializeSetupWizardAction(): void
    {
        $this->initializeDataTables();
        $this->pageRenderer->loadJavaScriptModule('@t3g/blog/setup-wizard.js');
    }

    public function initializePostsAction(): void
    {
        $this->initializeDataTables();
    }

    public function initializeCommentsAction(): void
    {
        $this->initializeDataTables();
        $this->pageRenderer->loadJavaScriptModule('@t3g/blog/mass-update.js');
    }

    protected function initializeDataTables(): void
    {
        $this->pageRenderer->loadJavaScriptModule('@t3g/blog/datatables.js');
        $this->pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/datatables.min.css', 'stylesheet', 'all', '', false);
    }

    public function setupWizardAction(): ResponseInterface
    {
        $this->view->assignMultiple([
            'blogSetups' => $this->setupService->determineBlogSetups(),
        ]);
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());

        return $this->htmlResponse($moduleTemplate->renderContent());
    }

    public function postsAction(int $blogSetup = null): ResponseInterface
    {
        $query = $this->postRepository->createQuery();
        $querySettings = $query->getQuerySettings();
        $querySettings->setIgnoreEnableFields(true);
        $this->postRepository->setDefaultQuerySettings($querySettings);

        $this->view->assignMultiple([
            'blogSetups' => $this->setupService->determineBlogSetups(),
            'activeBlogSetup' => $blogSetup,
            'posts' => $this->postRepository->findAllByPid($blogSetup),
        ]);
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());

        return $this->htmlResponse($moduleTemplate->renderContent());
    }

    public function commentsAction(string $filter = null, int $blogSetup = null): ResponseInterface
    {
        $this->view->assignMultiple([
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
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());

        return $this->htmlResponse($moduleTemplate->renderContent());
    }

    public function updateCommentStatusAction(string $status, string $filter = null, int $blogSetup = null, array $comments = [], int $comment = null): ResponseInterface
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

        return new RedirectResponse($this->uriBuilder->reset()->uriFor('comments', ['filter' => $filter, 'blogSetup' => $blogSetup]));
    }

    public function createBlogAction(array $data = null): ResponseInterface
    {
        if ($data !== null && $this->setupService->createBlogSetup($data)) {
            $this->addFlashMessage('Your blog setup has been created.', 'Congratulation');
        } else {
            $this->addFlashMessage('Sorry, your blog setup could not be created.', 'An error occurred', FlashMessage::ERROR);
        }

        return new RedirectResponse($this->uriBuilder->reset()->uriFor('setupWizard'));
    }
}
