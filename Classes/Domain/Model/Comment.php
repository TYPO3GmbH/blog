<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Comment extends AbstractEntity
{
    public const STATUS_PENDING = 0;
    public const STATUS_APPROVED = 10;
    public const STATUS_DECLINED = 50;
    public const STATUS_DELETED = 90;

    /**
     * The author of the comment.
     *
     * @var FrontendUser
     */
    protected $author;

    /**
     * The name of the comment author.
     *
     * @var string
     */
    protected $name;

    /**
     * The email of the comment author.
     *
     * @var string
     */
    protected $email;

    /**
     * The url of the comment author.
     *
     * @var string
     */
    protected $url;

    /**
     * The comment text.
     *
     * @var string
     */
    protected $comment;

    /**
     * Flag to determine if record is hidden.
     *
     * @var int
     */
    protected $hidden;

    /**
     * The post related to this comment.
     *
     * @var \T3G\AgencyPack\Blog\Domain\Model\Post
     */
    protected $post;

    /**
     * The honeypot field, field is not stored in database.
     *
     * @var string
     */
    protected $hp = '';

    /**
     * @var int
     */
    protected $postLanguageId;

    /**
     * The blog post creation date.
     *
     * @var \DateTime
     */
    protected $crdate;

    /**
     * @var int
     */
    protected $status;

    /**
     * @return FrontendUser
     */
    public function getAuthor(): ?FrontendUser
    {
        return $this->author;
    }

    /**
     * @param FrontendUser $author
     *
     * @return Comment
     */
    public function setAuthor(FrontendUser $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Comment
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Comment
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return int
     */
    public function getHidden(): ?int
    {
        return $this->hidden;
    }

    /**
     * @param int $hidden
     *
     * @return Comment
     */
    public function setHidden(int $hidden): self
    {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Comment
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return Post
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     *
     * @return Comment
     */
    public function setPost(Post $post): self
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCrdate(): ?\DateTime
    {
        return $this->crdate;
    }

    /**
     * @param \DateTime $crdate
     *
     * @return Comment
     */
    public function setCrdate(\DateTime $crdate): self
    {
        $this->crdate = $crdate;
        return $this;
    }

    /**
     * @return int
     */
    public function getPostLanguageId(): ?int
    {
        return $this->postLanguageId;
    }

    /**
     * @param int $postLanguageId
     * @return Comment
     */
    public function setPostLanguageId($postLanguageId): self
    {
        $this->postLanguageId = $postLanguageId;
        return $this;
    }

    /**
     * @return string
     */
    public function getHp(): ?string
    {
        return $this->hp;
    }

    /**
     * @param string $hp
     * @return Comment
     */
    public function setHp($hp): self
    {
        $this->hp = $hp;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Comment
     */
    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }
}
