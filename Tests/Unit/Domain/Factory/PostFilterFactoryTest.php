<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Domain\Factory;

use T3G\AgencyPack\Blog\Domain\Factory\PostFilterFactory;
use T3G\AgencyPack\Blog\Domain\Filter\Post\CategoryTag;
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Tests for the Post filter factory.
 */
class PostFilterFactoryTest extends UnitTestCase
{
    protected const REQUEST_CATEGORY = 'category';

    protected const REQUEST_TAG = 'tag';

    /**
     * @type array<int, string>
     */
    protected const CATEGORIES = [1 => 'category1', 2 => 'category2'];

    /**
     * @type array<int, string>
     */
    protected const TAGS = [1 => 'tag1', 2 => 'tag2'];

    /**
     * @var array<int, Category>
     */
    protected static array $categories = [];

    /**
     * @var array<int, Tag>
     */
    protected static array $tags = [];

    protected static CategoryRepository $categoryRepository;

    protected static TagRepository $tagRepository;

    public static function setUpBeforeClass(): void
    {
        foreach (self::CATEGORIES as $uid => $title) {
            $category = new Category();
            $category->setTitle($title);
            self::$categories[$uid] = $category;
        }
        $categoryRepository = self::createStub(CategoryRepository::class);
        $categoryRepository->method('findByUid')->willReturnCallback(fn(int $uid) => self::$categories[$uid]);
        self::$categoryRepository = $categoryRepository;

        foreach (self::TAGS as $uid => $title) {
            $tag = new Tag();
            $tag->setTitle($title);
            self::$tags[$uid] = $tag;
        }
        $tagRepository = self::createStub(TagRepository::class);
        $tagRepository->method('findByUid')->willReturnCallback(fn(int $uid) => self::$tags[$uid]);
        self::$tagRepository = $tagRepository;
    }

    /**
     * @test
     */
    public function constructor(): PostFilterFactory
    {
        return new PostFilterFactory(self::$categoryRepository, self::$tagRepository);
    }

    /**
     * @test
     * @depends constructor
     */
    public function getFilterFromRequestForEmptyRequest(PostFilterFactory $factory): void
    {
        /** @var CategoryTag $filter */
        $filter = $factory->getFilterFromRequest($this->createRequest());
        self::assertInstanceOf(CategoryTag::class, $filter);
        self::assertNull($filter->getCategory());
        self::assertNull($filter->getTag());
    }

    /**
     * @test
     * @depends constructor
     */
    public function getFilterFromRequestForSelectedCategory(PostFilterFactory $factory): void
    {
        /** @var CategoryTag $filter */
        $filter = $factory->getFilterFromRequest(
            $this->createRequest([
                self::REQUEST_CATEGORY => 1
            ])
        );
        self::assertInstanceOf(CategoryTag::class, $filter);
        self::assertSame(self::$categories[1], $filter->getCategory());
        self::assertNull($filter->getTag());
    }

    /**
     * @test
     * @depends constructor
     */
    public function getFilterFromRequestForSelectedTag(PostFilterFactory $factory): void
    {
        /** @var CategoryTag $filter */
        $filter = $factory->getFilterFromRequest(
            $this->createRequest([
                self::REQUEST_TAG => 2
            ])
        );
        self::assertInstanceOf(CategoryTag::class, $filter);
        self::assertNull($filter->getCategory());
        self::assertSame(self::$tags[2], $filter->getTag());
    }

    /**
     * @test
     * @depends constructor
     */
    public function getFilterFromRequestForSelectedCategoryAndTag(PostFilterFactory $factory): void
    {
        /** @var CategoryTag $filter */
        $filter = $factory->getFilterFromRequest(
            $this->createRequest([
                self::REQUEST_CATEGORY => 2,
                self::REQUEST_TAG => 1
            ])
        );
        self::assertInstanceOf(CategoryTag::class, $filter);
        self::assertSame(self::$categories[2], $filter->getCategory());
        self::assertSame(self::$tags[1], $filter->getTag());
    }

    protected function createRequest(array $arguments = []): RequestInterface
    {
        /** @var RequestInterface $request */
        $request = self::createMock(RequestInterface::class);
        $request
            ->expects($this->exactly(2))
            ->method('hasArgument')
            ->willReturnCallback(fn(string $argumentName) => array_key_exists($argumentName, $arguments));
        $request
            ->expects($this->exactly(count($arguments)))
            ->method('getArgument')
            ->willReturnCallback(fn(string $argumentName) => $arguments[$argumentName]);
        return $request;
    }
}
