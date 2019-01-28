<?php

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
use T3G\AgencyPack\Blog\AvatarProvider\GravatarProvider;
use T3G\AgencyPack\Blog\AvatarProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Author.
 *
 * This model is a representation of the author table.
 */
class Author extends AbstractEntity
{
    /**
     * @var string
     */
    protected $avatarProvider;

    /**
     * @var AvatarProviderInterface
     */
    protected $avatar;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var string
     */
    protected $twitter;

    /**
     * @var string
     */
    protected $googleplus;

    /**
     * @var string
     */
    protected $linkedin;

    /**
     * @var string
     */
    protected $xing;

    /**
     * @var string
     */
    protected $profile;

    /**
     * @var string
     */
    protected $bio;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Post>
     * @lazy
     */
    protected $posts;

    /**
     * @var int
     */
    protected $detailsPage;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->initializeObject();
    }

    /**
     * initializeObject
     */
    public function initializeObject()
    {
        $this->posts = new ObjectStorage();
    }

    /**
     * @return object|AvatarProviderInterface
     */
    public function getAvatarProvider()
    {
        return !empty($this->avatarProvider)
            ? GeneralUtility::makeInstance($this->avatarProvider)
            : GeneralUtility::makeInstance(GravatarProvider::class);
    }

    /**
     * @param string $avatarProvider
     */
    public function setAvatarProvider(string $avatarProvider)
    {
        $this->avatarProvider = $avatarProvider;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        if ($this->avatar === null) {
            $this->avatar = $this->getAvatarProvider();
        }
        return $this->avatar->getAvatarUrl($this);
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function setImage(FileReference $image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
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
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return string
     */
    public function getGoogleplus()
    {
        return $this->googleplus;
    }

    /**
     * @param string $googleplus
     */
    public function setGoogleplus($googleplus)
    {
        $this->googleplus = $googleplus;
    }

    /**
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * @param string $linkedin
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;
    }

    /**
     * @return string
     */
    public function getXing()
    {
        return $this->xing;
    }

    /**
     * @param string $xing
     */
    public function setXing($xing)
    {
        $this->xing = $xing;
    }

    /**
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @param Post $post
     */
    public function addPost(Post $post)
    {
        $this->posts->attach($post);
    }

    /**
     * @param Post $post
     */
    public function removePost(Post $post)
    {
        $this->posts->detach($post);
    }

    /**
     * @return ObjectStorage
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param ObjectStorage $posts
     */
    public function setPosts(ObjectStorage $posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return int
     */
    public function getDetailsPage()
    {
        return $this->detailsPage;
    }

    /**
     * @param int $page
     */
    public function setDetailsPage(int $page)
    {
        $this->detailsPage = $page;
    }
}
