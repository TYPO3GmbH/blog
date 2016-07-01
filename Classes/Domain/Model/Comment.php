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
 * Class Comment
 *
 * This model is a representation of the comment table.
 * Comments can be assigned to blog posts.
 */
class Comments extends AbstractEntity
{
    /**
     * The author of the comment
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
     * The email of the comment author
     *
     * @var string
     */
    protected $email;

    /**
     * The comment text
     *
     * @var string
     */
    protected $comment;

    /**
     * @return FrontendUser
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param FrontendUser $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
     */
    public function setName($name)
    {
        $this->name = $name;
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
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}