<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Model;

use T3G\AgencyPack\Blog\AvatarProvider\AvatarProviderInterface;
use T3G\AgencyPack\Blog\AvatarProvider\GravatarProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Author extends AbstractEntity
{
    protected string $avatarProvider = '';
    protected string $name = '';
    protected string $slug = '';
    protected string $title = '';
    protected ?FileReference $image = null;
    protected string $website = '';
    protected string $email = '';
    protected string $location = '';
    protected string $twitter = '';
    protected string $linkedin = '';
    protected string $xing = '';
    protected string $instagram = '';
    protected string $profile = '';
    protected string $bio = '';
    protected int $detailsPage = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3G\AgencyPack\Blog\Domain\Model\Post>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $posts;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->posts = new ObjectStorage();
    }

    public function getAvatarProvider(): AvatarProviderInterface
    {
        /** @var class-string<object>|'' $avatarProviderClassName */
        $avatarProviderClassName = trim($this->avatarProvider);
        $avatarProvider = $avatarProviderClassName !== ''
            ? GeneralUtility::makeInstance($avatarProviderClassName)
            : GeneralUtility::makeInstance(GravatarProvider::class);

        if (!$avatarProvider instanceof AvatarProviderInterface) {
            throw new \InvalidArgumentException('The avatarProvider must implement the "T3G\AgencyPack\Blog\AvatarProvider\AvatarProviderInterface" interface.', 1684505832);
        }

        return $avatarProvider;
    }

    public function setAvatarProvider(string $avatarProvider): self
    {
        $this->avatarProvider = $avatarProvider;
        return $this;
    }

    public function getAvatar(int $size = 64): string
    {
        return $this->getAvatarProvider()->getAvatarUrl($this, $size);
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
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

    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    public function setImage(FileReference $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getTwitter(): string
    {
        return $this->twitter;
    }

    public function setTwitter(string $twitter): self
    {
        $this->twitter = $twitter;
        return $this;
    }

    public function getLinkedin(): string
    {
        return $this->linkedin;
    }

    public function setLinkedin(string $linkedin): self
    {
        $this->linkedin = $linkedin;
        return $this;
    }

    public function getXing(): string
    {
        return $this->xing;
    }

    public function setXing(string $xing): self
    {
        $this->xing = $xing;
        return $this;
    }

    public function getInstagram(): string
    {
        return $this->instagram;
    }

    public function setInstagram(string $instagram): self
    {
        $this->instagram = $instagram;
        return $this;
    }

    public function getProfile(): string
    {
        return $this->profile;
    }

    public function setProfile(string $profile): self
    {
        $this->profile = $profile;
        return $this;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;
        return $this;
    }

    public function addPost(Post $post): self
    {
        $this->posts->attach($post);
        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->posts->detach($post);
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

    public function getDetailsPage(): int
    {
        return $this->detailsPage;
    }

    public function setDetailsPage(int $page): self
    {
        $this->detailsPage = $page;
        return $this;
    }

    public function getAllTags(): array
    {
        $uniqueTags = [];
        foreach ($this->getPosts() as $post) {
            foreach ($post->getTags() as $tag) {
                if (!array_key_exists((int) $tag->getUid(), $uniqueTags)) {
                    $uniqueTags[(int) $tag->getUid()] = $tag;
                }
            }
        }
        return $uniqueTags;
    }
}
