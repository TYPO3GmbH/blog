<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Utility;

use T3G\AgencyPack\Blog\Domain\Model\Author;
use T3G\AgencyPack\Blog\Utility\Socials\MastodonUtility;
use T3G\AgencyPack\Blog\Utility\Socials\TwitterXUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SchemaUtility
{
    // The output is embedded in a <script> element, where an unescaped < ends it.
    public const JSON_ENCODE_OPTIONS = JSON_THROW_ON_ERROR
        | JSON_UNESCAPED_SLASHES
        | JSON_UNESCAPED_UNICODE
        | JSON_HEX_TAG
        | JSON_HEX_AMP
        | JSON_HEX_APOS
        | JSON_HEX_QUOT;

    public static function buildPersonData(Author $author): array
    {
        $url = '';
        $sameAs = [];
        if ($author->getProfile() !== '') {
            $url = self::getAbsoluteUrl($author->getProfile());
        }

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $author->getName(),
        ];

        if ($url !== '') {
            $data['@id'] = sprintf('%s/#Person', rtrim($url, '/'));
            $data['url'] = $url;
            $sameAs[] = $url;
        }

        if ($author->getTitle() !== '') {
            $data['jobTitle'] = trim($author->getTitle());
        }
        if ($author->getLocation() !== '') {
            $data['homeLocation'] = [
                '@type' => 'Place',
                'name' => $author->getLocation(),
            ];
        }
        if ($author->getBio() !== '') {
            $data['description'] = strip_tags($author->getBio());
        }

        $imageUrl = self::getImageUrl($author);
        if ($imageUrl !== '') {
            $data['image'] = $imageUrl;
        }

        if ($author->getWebsite() !== '') {
            $sameAs[] = self::getAbsoluteUrl($author->getWebsite());
        }
        $twitterUrl = TwitterXUtility::getXUrl($author->getTwitter());
        if ($twitterUrl !== '') {
            $sameAs[] = $twitterUrl;
        }
        if ($author->getLinkedin() !== '') {
            $sameAs[] = self::getAbsoluteUrl($author->getLinkedin());
        }
        if ($author->getXing() !== '') {
            $sameAs[] = self::getAbsoluteUrl($author->getXing());
        }
        if ($author->getInstagram() !== '') {
            $sameAs[] = self::getAbsoluteUrl($author->getInstagram());
        }
        $mastodonUrl = MastodonUtility::getMastodonUrl($author->getMastodon());
        if ($mastodonUrl !== '') {
            $sameAs[] = $mastodonUrl;
        }

        if ($sameAs !== []) {
            $data['sameAs'] = array_unique($sameAs);
        }

        return $data;
    }

    /**
     * Author fields are plain input, and the website field even validates as a
     * domain name, so "www.example.com" is a common value. Resolving it against
     * the current page would point sameAs to the own site, so a missing scheme
     * becomes https instead, as f:uri.external does in the templates.
     */
    private static function getAbsoluteUrl(string $url): string
    {
        $url = trim($url);
        if ($url !== '' && !str_starts_with($url, '/') && parse_url($url, PHP_URL_SCHEME) === null) {
            return 'https://' . $url;
        }

        return GeneralUtility::locationHeaderUrl($url);
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
