<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Model;

use T3G\AgencyPack\Blog\AvatarProvider\GravatarProvider;
use T3G\AgencyPack\Blog\AvatarProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Author extends AbstractEntity
{
    /**
     * @var string
     */
    protected $avatarProvider = '';

    /**
     * @var AvatarProviderInterface
     */
    protected $avatar;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image;

    /**
     * @var string
     */
    protected $website = '';

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var string
     */
    protected $location = '';

    /**
     * @var string
     */
    protected $twitter = '';

    /**
     * @var string
     */
    protected $linkedin = '';

    /**
     * @var string
     */
    protected $xing = '';

    /**
     * @var string
     */
    protected $profile = '';

    /**
     * @var string
     */
    protected $bio = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Post>
     * @Extbase\ORM\Lazy
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
    public function initializeObject(): void
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
     * @return Author
     */
    public function setAvatarProvider(string $avatarProvider): self
    {
        $this->avatarProvider = $avatarProvider;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        if ($this->avatar === null) {
            $this->avatar = $this->getAvatarProvider();
        }
        return $this->avatar->getAvatarUrl($this);
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
     * @return Author
     */
    public function setName(string $name): self
    {
        $this->name = $name;
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Author
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return Author
     */
    public function setImage(FileReference $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return Author
     */
    public function setWebsite(string $website): self
    {
        $this->website = $website;
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
     * @return Author
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return Author
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     * @return Author
     */
    public function setTwitter(string $twitter): self
    {
        $this->twitter = $twitter;
        return $this;
    }

    /**
     * @return string
     */
    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    /**
     * @param string $linkedin
     * @return Author
     */
    public function setLinkedin(string $linkedin): self
    {
        $this->linkedin = $linkedin;
        return $this;
    }

    /**
     * @return string
     */
    public function getXing(): ?string
    {
        return $this->xing;
    }

    /**
     * @param string $xing
     * @return Author
     */
    public function setXing(string $xing): self
    {
        $this->xing = $xing;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfile(): ?string
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     * @return Author
     */
    public function setProfile(string $profile): self
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @return string
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     * @return Author
     */
    public function setBio(string $bio): self
    {
        $this->bio = $bio;
        return $this;
    }

    /**
     * @param Post $post
     * @return Author
     */
    public function addPost(Post $post): self
    {
        $this->posts->attach($post);
        return $this;
    }

    /**
     * @param Post $post
     * @return Author
     */
    public function removePost(Post $post): self
    {
        $this->posts->detach($post);
        return $this;
    }

    /**
     * @return ObjectStorage
     */
    public function getPosts(): ObjectStorage
    {
        return $this->posts;
    }

    /**
     * @param ObjectStorage $posts
     * @return Author
     */
    public function setPosts(ObjectStorage $posts): self
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * @return int
     */
    public function getDetailsPage(): ?int
    {
        return $this->detailsPage;
    }

    /**
     * @param int $page
     * @return Author
     */
    public function setDetailsPage(int $page): self
    {
        $this->detailsPage = $page;
        return $this;
    }
}
