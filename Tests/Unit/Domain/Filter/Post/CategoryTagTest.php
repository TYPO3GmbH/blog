<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Domain\Filter\Post;

use T3G\AgencyPack\Blog\Domain\Filter\Post\CategoryTag;
use T3G\AgencyPack\Blog\Domain\Filter\PostFilter;
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use T3G\AgencyPack\Blog\Tests\AssertionsTrait;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Tests for Post filter CategoryTag.
 */
class CategoryTagTest extends UnitTestCase
{
    use AssertionsTrait;

    protected const CATEGORY_TITLE = 'catTitle';

    protected const CATEGORY_DESCRIPTION = 'The description of the category.';

    protected const TAG_TITLE = 'tagTitle';

    protected const TAG_DESCRIPTION = 'The description of the tag.';

    protected const QUERY_CATEGORIES = 'categories';

    protected const QUERY_TAGS = 'tags';

    /**
     * @test
     */
    public function constructor(): CategoryTag
    {
        $filter = new CategoryTag();
        self::assertInstanceOf(PostFilter::class, $filter);
        return $filter;
    }

    /**
     * @test
     * @depends constructor
     */
    public function getTitleForEmptyFilter(CategoryTag $filter): CategoryTag
    {
        self::assertEmpty($filter->getTitle());
        return $filter;
    }

    /**
     * @test
     * @depends constructor
     */
    public function getDescriptionForEmptyFilter(CategoryTag $filter): CategoryTag
    {
        self::assertEmpty($filter->getDescription());
        return $filter;
    }

    /**
     * @test
     * @depends constructor
     */
    public function getConstraintsForEmptyFilter(CategoryTag $filter): void
    {
        self::assertEmpty($filter->getConstraints(self::createStub(QueryInterface::class)));
    }

    /**
     * @test
     * @depends constructor
     */
    public function getNameReturnsClassNameWithoutNamespace(CategoryTag $filter): void
    {
        self::assertSame('CategoryTag', $filter->getName());
    }

    /**
     * @test
     * @depends constructor
     */
    public function getCategoryReturnsNullInitially(CategoryTag $filter): CategoryTag
    {
        self::assertNull($filter->getCategory());
        return $filter;
    }

    /**
     * @test
     * @depends constructor
     */
    public function getTagReturnsNullInitially(CategoryTag $filter): CategoryTag
    {
        self::assertNull($filter->getTag());
        return $filter;
    }

    /**
     * @test
     */
    public function getCategoryAfterSetCategory(): CategoryTag
    {
        $filter = new CategoryTag();
        $category = $this->createCategory();
        $filter->setCategory($category);
        self::assertSame($category, $filter->getCategory());
        return $filter;
    }

    /**
     * @test
     */
    public function getTagAfterSetTag(): CategoryTag
    {
        $filter = new CategoryTag();
        $tag = $this->createTag();
        $filter->setTag($tag);
        self::assertSame($tag, $filter->getTag());
        return $filter;
    }

    /**
     * @test
     * @depends getCategoryAfterSetCategory
     */
    public function getTitleForCategoryFilter(CategoryTag $filter): void
    {
        self::assertSame(self::CATEGORY_TITLE, $filter->getTitle());
    }

    /**
     * @test
     * @depends getCategoryAfterSetCategory
     */
    public function getDescriptionForCategoryFilter(CategoryTag $filter): void
    {
        self::assertSame(self::CATEGORY_DESCRIPTION, $filter->getDescription());
    }

    /**
     * @test
     * @depends getCategoryAfterSetCategory
     */
    public function getConstraintsForCategoryFilter(CategoryTag $filter): void
    {
        $query = self::createMock(QueryInterface::class);
        $query
            ->expects($this->once())
            ->method('contains')->with(self::QUERY_CATEGORIES, $this->createCategory())
            ->willReturnCallback(fn(string $name, Category $category) => [$name => $category->getTitle()]);
        $constraints = $filter->getConstraints($query);
        self::assertArrayOfArrays(1, $constraints, 0);
        self::assertArrayKeyValue(self::QUERY_CATEGORIES, self::CATEGORY_TITLE, $constraints[0]);
    }

    /**
     * @test
     * @depends getTagAfterSetTag
     */
    public function getTitleForTagFilter(CategoryTag $filter): void
    {
        self::assertSame(self::TAG_TITLE, $filter->getTitle());
    }

    /**
     * @test
     * @depends getTagAfterSetTag
     */
    public function getDescriptionForTagFilter(CategoryTag $filter): void
    {
        self::assertSame(self::TAG_DESCRIPTION, $filter->getDescription());
    }

    /**
     * @test
     * @depends getTagAfterSetTag
     */
    public function getConstraintsForTagFilter(CategoryTag $filter): void
    {
        $query = self::createMock(QueryInterface::class);
        $query
            ->expects($this->once())
            ->method('contains')->with(self::QUERY_TAGS, $this->createTag())
            ->willReturnCallback(fn(string $name, Tag $tag) => [$name => $tag->getTitle()]);
        $constraints = $filter->getConstraints($query);
        self::assertArrayOfArrays(1, $constraints, 0);
        self::assertArrayKeyValue(self::QUERY_TAGS, self::TAG_TITLE, $constraints[0]);
    }

    /**
     * @test
     * @depends getCategoryAfterSetCategory
     */
    public function getTitleForCategoryTagFilter(CategoryTag $filter): CategoryTag
    {
        $filter->setTag($this->createTag());
        self::assertSame(self::CATEGORY_TITLE . ' ' . self::TAG_TITLE, $filter->getTitle());
        return $filter;
    }

    /**
     * @test
     * @depends getTitleForCategoryTagFilter
     */
    public function getDescriptionForCategoryTagFilter(CategoryTag $filter): void
    {
        self::assertSame(self::CATEGORY_DESCRIPTION . ' ' . self::TAG_DESCRIPTION, $filter->getDescription());
    }

    /**
     * @test
     * @depends getTitleForCategoryTagFilter
     */
    public function getConstraintsForCategoryTagFilter(CategoryTag $filter): void
    {
        $query = self::createMock(QueryInterface::class);
        $query
            ->expects($this->exactly(2))
            ->method('contains')
            ->willReturnCallback(fn(string $name, $categoryOrTag) => [$name => $categoryOrTag->getTitle()]);
        $constraints = $filter->getConstraints($query);
        self::assertArrayOfArrays(2, $constraints, [0, 1]);
        self::assertArrayKeyValue(self::QUERY_CATEGORIES, self::CATEGORY_TITLE, $constraints[0]);
        self::assertArrayKeyValue(self::QUERY_TAGS, self::TAG_TITLE, $constraints[1]);
    }

    protected function createCategory(): Category
    {
        $category = new Category();
        $category->setTitle(self::CATEGORY_TITLE);
        $category->setDescription(self::CATEGORY_DESCRIPTION);
        return $category;
    }

    protected function createTag(): Tag
    {
        $tag = new Tag();
        $tag->setTitle(self::TAG_TITLE);
        $tag->setDescription(self::TAG_DESCRIPTION);
        return $tag;
    }
}
