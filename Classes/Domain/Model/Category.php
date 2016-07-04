<?php
namespace T3G\AgencyPack\Blog\Domain\Model;

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
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class Category
 *
 * This model is a representation of the sys_category table.
 * Categories can be assigned to blog posts.
 */
class Category extends AbstractEntity
{
    /**
     * @var string
     * @validate notEmpty
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $icon = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\Category|NULL
     * @lazy
     */
    protected $parent;

    /**
     * The additional content of the category. Used to enrich the SEO rating of category pages.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Content>
     */
    protected $content;

    /**
     * Gets the title.
     *
     * @return string the title, might be empty
     * @api
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title.
     *
     * @param string $title the title to set, may be empty
     * @return void
     * @api
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Gets the description.
     *
     * @return string the description, might be empty
     * @api
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description.
     *
     * @param string $description the description to set, may be empty
     * @return void
     * @api
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the icon
     *
     * @return string $icon
     * @api
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Sets the icon
     *
     * @param string $icon
     * @return void
     * @api
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * Gets the parent category.
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\Category|NULL the parent category
     * @api
     */
    public function getParent()
    {
        if ($this->parent instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->parent->_loadRealInstance();
        }
        return $this->parent;
    }

    /**
     * Sets the parent category.
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $parent the parent category
     * @return void
     * @api
     */
    public function setParent(\TYPO3\CMS\Extbase\Domain\Model\Category $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentElementUidList()
    {
        $uidList = array();
        $contentElements = $this->getContent();
        if ($contentElements) {
            foreach ($contentElements as $contentElement) {
                $uidList[] = $contentElement->getUid();
            }
        }
        return implode(',', $uidList);
    }
}
