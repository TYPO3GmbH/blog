<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Filter\Post;

use T3G\AgencyPack\Blog\Domain\Model\Category;
use T3G\AgencyPack\Blog\Domain\Model\Tag;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * This filter combines one selected Category and one selected Tag (both optional).
 */
class CategoryTag extends AbstractBase
{
    protected ?Category $category = null;

    protected ?Tag $tag = null;

    /**
     * Title is simply the concatenated Category and Tag titles (separated by a SPACE character).
     */
    public function getTitle(): string
    {
        if ($this->category) {
            if ($this->tag) {
                return trim($this->category->getTitle() . ' ' . $this->tag->getTitle());
            } else {
                return $this->category->getTitle();
            }
        }
        if ($this->tag) {
            return $this->tag->getTitle();
        }
        return '';
    }

    /**
     * Description is simply the concatenated Category and Tag titles (separated by a SPACE character).
     */
    public function getDescription(): string
    {
        if ($this->category) {
            if ($this->tag) {
                return trim($this->category->getDescription() . ' ' . $this->tag->getDescription());
            } else {
                return $this->category->getDescription();
            }
        }
        if ($this->tag) {
            return $this->tag->getDescription();
        }
        return '';
    }

    /**
     * @return array<ComparisonInterface>
     * @throws InvalidQueryException
     */
    public function getConstraints(QueryInterface $query): array
    {
        $constraints = [];
        if ($this->category) {
            $constraints[] = $query->contains('categories', $this->category);
        }
        if ($this->tag) {
            $constraints[] = $query->contains('tags', $this->tag);
        }
        return $constraints;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): void
    {
        $this->tag = $tag;
    }
}
