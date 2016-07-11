<?php

namespace T3G\AgencyPack\Blog\Tests\Unit;


use Prophecy\Prophecy\ObjectProphecy;
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Service\CommentService;

/**
 * Class CommentServiceTest
 *
 *
 * @todo add the hidden test ;)
 * @package T3G\AgencyPack\Blog\Tests\Unit
 */
class CommentServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PostRepository|ObjectProphecy
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
     * @return void
     */
    public function inactiveCommentsReturnErrorOnAdd()
    {
        $post = new Post();
        $comment = new Comment();

        $commentService = new CommentService();
        $result = $commentService->addComment($post, $comment);

        self::assertSame('error', $result);
    }

    /**
     * @test
     * @return void
     */
    public function activeCommentsWithoutModerationReturnSuccessOnAdd()
    {
        $post = new Post();
        $comment = new Comment();
        $settings = ['active' => 1, 'moderation' => 0];

        $this->commentService->injectSettings($settings);
        $result = $this->commentService->addComment($post, $comment);

        self::assertSame('success', $result);
    }

    /**
     * @test
     * @return void
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
     * @return void
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
