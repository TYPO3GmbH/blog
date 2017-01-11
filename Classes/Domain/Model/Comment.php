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
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class Comment.
 *
 * This model is a representation of the comment table.
 * Comments can be assigned to blog posts.
 */
class Comment extends AbstractEntity
{
    /**
     * The author of the comment.
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
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
     * @return FrontendUser
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param FrontendUser $author
     *
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Comment
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Comment
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return int
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param int $hidden
     *
     * @return Comment
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Comment
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     *
     * @return Comment
     */
    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param \DateTime $crdate
     *
     * @return Comment
     */
    public function setCrdate(\DateTime $crdate)
    {
        $this->crdate = $crdate;

        return $this;
    }

    /**
     * @return int
     */
    public function getPostLanguageId()
    {
        return $this->postLanguageId;
    }

    /**
     * @param int $postLanguageId
     */
    public function setPostLanguageId($postLanguageId)
    {
        $this->postLanguageId = $postLanguageId;
    }

    /**
     * @return string
     */
    public function getHp() : string
    {
        return $this->hp;
    }

    /**
     * @param string $hp
     */
    public function setHp(string $hp)
    {
        $this->hp = $hp;
    }
}
