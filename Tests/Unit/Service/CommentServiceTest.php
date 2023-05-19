<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Service;

use PHPUnit\Framework\MockObject\MockObject;
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\CommentService;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class CommentServiceTest extends UnitTestCase
{
    protected bool $resetSingletonInstances = true;
    protected MockObject $postRepositoryMock;
    protected MockObject $commentRepositoryMock;
    protected MockObject $persistenceManagerMock;
    protected CommentService $commentService;

    public function initialize(): void
    {
        $GLOBALS['TSFE'] =  $this->getMockBuilder(TypoScriptFrontendController::class)->disableOriginalConstructor()->getMock();
        $this->postRepositoryMock = $this->getMockBuilder(PostRepository::class)->disableOriginalConstructor()->getMock();
        $this->commentRepositoryMock = $this->getMockBuilder(CommentRepository::class)->disableOriginalConstructor()->getMock();
        $this->persistenceManagerMock = $this->getMockBuilder(PersistenceManager::class)->disableOriginalConstructor()->getMock();

        $this->commentService = new CommentService(
            $this->postRepositoryMock,
            $this->commentRepositoryMock,
            $this->persistenceManagerMock
        );
    }

    /**
     * @test
     */
    public function inactiveCommentsReturnErrorOnAdd(): void
    {
        $this->initialize();

        $post = new Post();
        $post->_setProperty('uid', 1);
        $comment = new Comment();
        $result = $this->commentService->addComment($post, $comment);

        self::assertSame(CommentService::STATE_ERROR, $result);
    }

    /**
     * @test
     */
    public function activeCommentsWithoutModerationReturnSuccessOnAdd(): void
    {
        $this->initialize();

        $post = new Post();
        $post->_setProperty('uid', 1);
        $comment = new Comment();

        $this->commentService->setSettings(['active' => 1, 'moderation' => 0]);
        $result = $this->commentService->addComment($post, $comment);

        self::assertEquals(0, $comment->getHidden());
        self::assertSame(CommentService::STATE_SUCCESS, $result);
    }

    /**
     * @test
     */
    public function activeCommentsWithModerationReturnModerationOnAdd(): void
    {
        $this->initialize();

        $post = new Post();
        $post->_setProperty('uid', 1);
        $comment = new Comment();

        $this->commentService->setSettings(['active' => 1, 'moderation' => 1]);
        $result = $this->commentService->addComment($post, $comment);

        self::assertEquals(Comment::STATUS_PENDING, $comment->getStatus());
        self::assertSame(CommentService::STATE_MODERATION, $result);
    }

    /**
     * @test
     */
    public function commentGetsAddedToPost(): void
    {
        $this->initialize();

        $post = new Post();
        $post->_setProperty('uid', 1);
        $comment = new Comment();

        $this->commentService->setSettings(['active' => 1, 'moderation' => 0]);
        $this->commentService->addComment($post, $comment);

        self::assertSame($comment, $post->getComments()->current());
    }

    /**
     * @test
     */
    public function postGetsUpdatedInDatabase(): void
    {
        $this->initialize();

        $this->postRepositoryMock
            ->expects(self::once())
            ->method('update');

        $post = new Post();
        $post->_setProperty('uid', 1);
        $comment = new Comment();

        $this->commentService->setSettings(['active' => 1, 'moderation' => 0]);
        $this->commentService->addComment($post, $comment);
    }
}
