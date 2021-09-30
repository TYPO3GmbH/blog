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

class PostRepositoryDemand
{
    /**
     * @var array
     */
    protected $categories = [];

    /**
     * @var string
     */
    protected $categoriesConjunction = Constants::REPOSITORY_CONJUNCTION_AND;

    /**
     * @param Category $category
     * @return PostRepositoryDemand
     */
    public function addCategory(Category $category): self
    {
        if (!isset($this->categories[$category->getUid()])) {
            $this->categories[$category->getUid()] = $category;
        }
        return $this;
    }

    /**
     * @param Category $category
     * @return PostRepositoryDemand
     */
    public function removeCategory(Category $category): self
    {
        if (isset($this->categories[$category->getUid()])) {
            unset($this->categories[$category->getUid()]);
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

    /**
     * @param string $categoriesConjunction
     * @return PostRepositoryDemand
     */
    public function setCategoriesConjunction(string $categoriesConjunction)
    {
        if ($categoriesConjunction === Constants::REPOSITORY_CONJUNCTION_AND
            || $categoriesConjunction === Constants::REPOSITORY_CONJUNCTION_OR) {
            $this->categoriesConjunction = $categoriesConjunction;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCategoriesConjunction(): string
    {
        return $this->categoriesConjunction;
    }
}
