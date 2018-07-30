<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit;

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

use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\CommentService;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Class CommentServiceTest.
 */
class CommentServiceTest extends UnitTestCase
{
    /**
     * @var PostRepository
     */
    protected $postRepositoryProphecy;

    /**
     * @var CommentService
     */
    protected $commentService;

    public function setUp()
    {
        $this->postRepositoryProphecy = $this->prophesize(PostRepository::class);
        $this->commentService = new CommentService();
        $this->commentService->injectPostRepository($this->postRepositoryProphecy->reveal());
    }
    /**
     * @test
     */
    public function inactiveCommentsReturnErrorOnAdd()
    {
        $post = new Post();
        $comment = new Comment();

        $commentService = new CommentService();
        $result = $commentService->addComment($post, $comment);

        self::assertSame(CommentService::STATE_ERROR, $result);
    }

    /**
     * @test
     */
    public function activeCommentsWithoutModerationReturnSuccessOnAdd()
    {
        $post = new Post();
        $comment = new Comment();
        $settings = ['active' => 1, 'moderation' => 0];

        $this->commentService->injectSettings($settings);
        $result = $this->commentService->addComment($post, $comment);

        self::assertEquals(0, $comment->getHidden());
        self::assertSame(CommentService::STATE_SUCCESS, $result);
    }

    /**
     * @test
     */
    public function activeCommentsWithModerationReturnModerationOnAdd()
    {
        $post = new Post();
        $comment = new Comment();
        $settings = ['active' => 1, 'moderation' => 1];

        $this->commentService->injectSettings($settings);
        $result = $this->commentService->addComment($post, $comment);

        self::assertEquals(Comment::STATUS_PENDING, $comment->getStatus());
        self::assertSame(CommentService::STATE_MODERATION, $result);
    }

    /**
     * @test
     */
    public function commentGetsAddedToPost()
    {
        $post = new Post();
        $comment = new Comment();

        $settings = ['active' => 1, 'moderation' => 0];

        $this->commentService->injectSettings($settings);
        $this->commentService->addComment($post, $comment);

        self::assertSame($comment, $post->getComments()->current());
    }

    /**
     * @test
     */
    public function postGetsUpdatedInDatabase()
    {
        $post = new Post();
        $comment = new Comment();

        $settings = ['active' => 1, 'moderation' => 0];

        $this->commentService->injectSettings($settings);
        $this->commentService->addComment($post, $comment);

        $this->postRepositoryProphecy->update($post)->shouldHaveBeenCalled();
    }
}
