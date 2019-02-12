<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

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
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Tag.
 *
 * This model is a representation of the tag table.
 * Tags can be assigned to blog posts.
 */
class Tag extends AbstractEntity
{
    /**
     * The title of the tag.
     *
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     * The description of the tag. Used for SEO meta description.
     *
     * @var string
     */
    protected $description;

    /**
     * The additional content of the tag. Used to enrich the SEO rating of tag pages.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Content>
     * @Extbase\ORM\Lazy
     */
    protected $content;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->initializeObject();
    }

    /**
     * initializeObject
     */
    public function initializeObject(): void
    {
        /** @extensionScannerIgnoreLine */
        $this->content = new ObjectStorage();
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Tag
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Tag
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getContent(): ObjectStorage
    {
        /** @extensionScannerIgnoreLine */
        return $this->content;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $content
     * @return Tag
     */
    public function setContent($content): self
    {
        /** @extensionScannerIgnoreLine */
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentElementUidList(): string
    {
        $uidList = [];
        $contentElements = $this->getContent();
        if ($contentElements) {
            foreach ($contentElements as $contentElement) {
                $uidList[] = $contentElement->getUid();
            }
        }

        return implode(',', $uidList);
    }
}
