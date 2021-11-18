<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Controller;

use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Service\SetupService;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

class BackendController extends ActionController
{
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

    /**
     * @var string
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

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

    /**
     * @param ViewInterface $view
     */
    protected function initializeView(ViewInterface $view)
    {
        if ($view->getModuleTemplate() !== null) {
            $pageRenderer = $view->getModuleTemplate()->getPageRenderer();

            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/Tooltip');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Blog/Datatables');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Blog/SetupWizard');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Blog/MassUpdate');

            $pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/backend.min.css', 'stylesheet', 'all', '', false);
            $pageRenderer->addCssFile('EXT:blog/Resources/Public/Css/Datatables.min.css', 'stylesheet', 'all', '', false);

            $view->assign('action', $this->actionMethodName);
        }
    }

    public function setupWizardAction()
    {
        $this->view->assignMultiple([
            'blogSetups' => $this->setupService->determineBlogSetups()
        ]);
    }

    public function postsAction(int $blogSetup = null)
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
    }

    public function commentsAction(string $filter = null, int $blogSetup = null)
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
    }

    public function updateCommentStatusAction(
        string $status,
        string $filter = null,
        int $blogSetup = null,
        array $comments = [],
        int $comment = null
    ): void {
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
     */
    public function createBlogAction(array $data = null): void
    {
        if ($this->setupService->createBlogSetup($data)) {
            $this->addFlashMessage('Your blog setup has been created.', 'Congratulation');
        } else {
            $this->addFlashMessage('Sorry, your blog setup could not be created.', 'An error occurred', FlashMessage::ERROR);
        }
        $this->redirect('setupWizard');
    }
}
