<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Model;

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Category extends AbstractEntity
{
    /**
     * @Extbase\Validate("NotEmpty")
     */
    protected string $title = '';
    protected string $slug = '';
    protected string $description = '';
    protected int $recordType = Constants::CATEGORY_TYPE_BLOG;

    /**
     * @var \T3G\AgencyPack\Blog\Domain\Model\Category
     * @Extbase\ORM\Lazy
     */
    protected $parent;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Content>
     * @Extbase\ORM\Lazy
     */
    protected $content;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Post>
     * @Extbase\ORM\Lazy
     */
    protected $posts;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->content = new ObjectStorage();
        $this->posts = new ObjectStorage();
    }

    public function getRecordType(): int
    {
        return $this->recordType;
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(self $parent): self
    {
        $this->parent = $parent;
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
    public function setContent(ObjectStorage $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Post>
     */
    public function getPosts(): ObjectStorage
    {
        return $this->posts;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Post> $posts
     */
    public function setPosts(ObjectStorage $posts): self
    {
        $this->posts = $posts;
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
