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
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Typolink\LinkFactory;

class Post extends AbstractEntity
{
    protected bool $hidden = false;
    protected int $doktype = Constants::DOKTYPE_BLOG_POST;
    protected string $title = '';
    protected string $subtitle = '';
    protected string $abstract = '';
    protected string $description = '';
    protected bool $commentsActive = true;
    protected int $archiveDate = 0;
    protected int $publishDate = 0;
    protected \DateTime $crdate;
    protected int $crdateMonth = 0;
    protected int $crdateYear = 0;
    protected ?FileReference $featuredImage = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Category>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $categories;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Comment>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $comments;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Tag>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $tags;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $media;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Author>
     * @Extbase\ORM\Lazy
     */
    protected $authors;

    public function __construct()
    {
        $this->initializeObject();
    }

    /**
     * initializeObject
     */
    public function initializeObject(): void
    {
        $this->categories = new ObjectStorage();
        $this->comments = new ObjectStorage();
        $this->tags = new ObjectStorage();
        $this->authors = new ObjectStorage();
        $this->media = new ObjectStorage();
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function isHidden(): bool
    {
        return $this->getHidden();
    }

    public function getDoktype(): int
    {
        return $this->doktype;
    }

    public function addAuthor(Author $author): self
    {
        $this->authors->attach($author);
        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->authors->detach($author);
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Author>
     */
    public function getAuthors(): ObjectStorage
    {
        return $this->authors;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Author> $authors
     * @return Post
     */
    public function setAuthors(ObjectStorage $authors): self
    {
        $this->authors = $authors;
        return $this;
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

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    public function getAbstract(): string
    {
        return $this->abstract;
    }

    public function setAbstract(string $abstract): self
    {
        $this->abstract = $abstract;
        return $this;
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
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Category>
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Category> $categories
     */
    public function setCategories($categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category): self
    {
        $this->categories->attach($category);
        return $this;
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category): self
    {
        $this->categories->detach($category);
        return $this;
    }

    public function getCrdate(): \DateTime
    {
        return $this->crdate;
    }

    public function setCrdate(\DateTime $crdate): self
    {
        $this->crdate = $crdate;
        return $this;
    }

    public function getCommentsActive(): bool
    {
        return $this->commentsActive;
    }

    public function setCommentsActive(bool $commentsActive): self
    {
        $this->commentsActive = $commentsActive;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Comment>
     */
    public function getComments(): ObjectStorage
    {
        return $this->comments;
    }

    public function getActiveComments(): QueryResultInterface
    {
        return GeneralUtility::makeInstance(CommentRepository::class)
            ->findAllByPost($this);
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Comment> $comments
     */
    public function setComments(ObjectStorage $comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment): self
    {
        $this->comments->attach($comment);
        return $this;
    }

    /**
     * @param Comment $comment
     */
    public function removeComment(Comment $comment): self
    {
        $this->comments->detach($comment);
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Tag>
     */
    public function getTags(): ObjectStorage
    {
        return $this->tags;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Tag> $tags
     */
    public function setTags(ObjectStorage $tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag): self
    {
        $this->tags->attach($tag);
        return $this;
    }

    /**
     * @param Tag $tag
     */
    public function removeTag(Tag $tag): self
    {
        $this->tags->detach($tag);
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getMedia(): ObjectStorage
    {
        return $this->media;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
     */
    public function setMedia(ObjectStorage $media): self
    {
        $this->media = $media;
        return $this;
    }

    public function getFeaturedImage(): ?FileReference
    {
        return $this->featuredImage;
    }

    public function setFeaturedImage(?FileReference $featuredImage): self
    {
        $this->featuredImage = $featuredImage;
        return $this;
    }

    public function getArchiveDate(): int
    {
        return $this->archiveDate;
    }

    public function setArchiveDate(int $archiveDate): self
    {
        $this->archiveDate = $archiveDate;
        return $this;
    }

    public function getPublishDate(): int
    {
        return $this->publishDate;
    }

    public function setPublishDate(int $publishDate): self
    {
        $this->publishDate = $publishDate;
        return $this;
    }

    public function getCrdateMonth(): int
    {
        return $this->crdateMonth;
    }

    public function getCrdateYear(): int
    {
        return $this->crdateYear;
    }

    public function getUri(): string
    {
        return (string) GeneralUtility::makeInstance(LinkFactory::class)->create(
            '',
            [
                'parameter' => (string) $this->getUid(),
                'forceAbsoluteUrl' => true
            ],
            GeneralUtility::makeInstance(ContentObjectRenderer::class)
        )->getUrl();
    }

    public function getAsArray(): array
    {
        return $this->__toArray();
    }

    public function __toArray(): array
    {
        return [
            'uid' => $this->getUid(),
            'hidden' => $this->getHidden(),
            'doktype' => $this->getDoktype(),
            'title' => $this->getTitle(),
            'subtitle' => $this->getSubtitle(),
            'abstract' => $this->getAbstract(),
            'description' => $this->getDescription()
        ];
    }
}
