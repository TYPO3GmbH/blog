<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\DataTransferObject;

use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Tag;

class PostRepositoryDemand
{
    /**
     * @var int[]
     */
    protected array $posts = [];

    /**
     * @var Category[]
     */
    protected array $categories = [];
    protected string $categoriesConjunction = Constants::REPOSITORY_CONJUNCTION_AND;

    /**
     * @var Tag[]
     */
    protected array $tags = [];
    protected string $tagsConjunction = Constants::REPOSITORY_CONJUNCTION_AND;

    /**
     * @var string[]
     */
    protected array $ordering = [];

    protected int $limit = 0;

    /**
     * @return int[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    /**
     * @param int[] $posts
     */
    public function setPosts(array $posts): self
    {
        $this->posts = array_filter(array_map('intval', array_unique($posts)));

        return $this;
    }

    public function addPost(int $uid): self
    {
        if (!in_array($uid, $this->posts, true)) {
            $this->posts[] = $uid;
        }

        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!isset($this->categories[$category->getUid()])) {
            $this->categories[$category->getUid()] = $category;
        }
        return $this;
    }

    public function removeCategory(Category $category): self
    {
        unset($this->categories[$category->getUid()]);
        return $this;
    }

    public function getCategoriesConjunction(): string
    {
        return $this->categoriesConjunction;
    }

    public function setCategoriesConjunction(string $categoriesConjunction): self
    {
        if ($categoriesConjunction === Constants::REPOSITORY_CONJUNCTION_AND
            || $categoriesConjunction === Constants::REPOSITORY_CONJUNCTION_OR) {
            $this->categoriesConjunction = $categoriesConjunction;
        }

        return $this;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!isset($this->tags[$tag->getUid()])) {
            $this->tags[$tag->getUid()] = $tag;
        }
        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        unset($this->tags[$tag->getUid()]);
        return $this;
    }

    public function getTagsConjunction(): string
    {
        return $this->tagsConjunction;
    }

    public function setTagsConjunction(string $tagsConjunction): self
    {
        if ($tagsConjunction === Constants::REPOSITORY_CONJUNCTION_AND
            || $tagsConjunction === Constants::REPOSITORY_CONJUNCTION_OR) {
            $this->tagsConjunction = $tagsConjunction;
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getOrdering(): array
    {
        return $this->ordering;
    }

    public function setOrdering(string $fieldName, string $direction): self
    {
        $this->ordering = ['field' => $fieldName, 'direction' => $direction];
        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }
}
