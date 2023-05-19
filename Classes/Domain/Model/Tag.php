<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Tag extends AbstractEntity
{
    protected string $title;
    protected string $slug;
    protected string $description;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Content>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $content;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->content = new ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Content>
     */
    public function getContent(): ObjectStorage
    {
        return $this->content;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Content> $content
     */
    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getContentElementUidList(): string
    {
        $uidList = [];
        $contentElements = $this->getContent();
        foreach ($contentElements as $contentElement) {
            $uidList[] = $contentElement->getUid();
        }

        return implode(',', $uidList);
    }
}
