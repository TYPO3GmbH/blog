<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Schema;

use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PersonViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('author', Author::class, 'The author', true);
        $this->registerArgument('url', 'string', 'The absolute author page URL');
    }

    public function render(): string
    {
        /** @var Author $author */
        $author = $this->arguments['author'];
        return (string)json_encode(
            self::buildPersonData($author, $this->arguments['url'] ?? null),
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    public static function buildPersonData(Author $author, ?string $authorPageUrl = null): array
    {
        $profile = self::normalizeUrl($author->getProfile());
        $url = $profile !== '' ? $profile : self::normalizeUrl((string)$authorPageUrl);

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $author->getName(),
        ];

        if ($url !== '') {
            $data['@id'] = rtrim($url, '/') . '/#person';
            $data['url'] = $url;
        }

        if (trim($author->getTitle()) !== '') {
            $data['jobTitle'] = trim($author->getTitle());
        }
        if (trim($author->getLocation()) !== '') {
            $data['homeLocation'] = [
                '@type' => 'Place',
                'name' => trim($author->getLocation()),
            ];
        }
        if (trim($author->getBio()) !== '') {
            $data['description'] = trim(strip_tags($author->getBio()));
        }

        $imageUrl = self::getImageUrl($author);
        if ($imageUrl !== '') {
            $data['image'] = $imageUrl;
        }

        $sameAs = array_values(array_unique(array_filter([
            $profile,
            self::normalizeUrl($author->getWebsite()),
            self::buildTwitterUrl($author->getTwitter()),
            self::normalizeUrl($author->getLinkedin()),
            self::normalizeUrl($author->getXing()),
            self::normalizeUrl($author->getInstagram()),
        ], static fn (string $url): bool => $url !== '')));

        if ($sameAs !== []) {
            $data['sameAs'] = $sameAs;
        }

        return $data;
    }

    private static function buildTwitterUrl(string $twitter): string
    {
        $twitter = trim($twitter);
        if ($twitter === '') {
            return '';
        }
        if (str_starts_with($twitter, 'http://') || str_starts_with($twitter, 'https://')) {
            return $twitter;
        }
        return 'https://twitter.com/' . ltrim($twitter, '@');
    }

    private static function normalizeUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            return '';
        }
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }
        if (str_starts_with($url, '//')) {
            return 'https:' . $url;
        }
        return 'https://' . $url;
    }

    private static function getImageUrl(Author $author): string
    {
        $image = $author->getImage();
        if ($image === null) {
            return '';
        }

        $publicUrl = $image->getOriginalResource()->getPublicUrl();
        if ($publicUrl === null) {
            return '';
        }

        return GeneralUtility::locationHeaderUrl($publicUrl);
    }
}
