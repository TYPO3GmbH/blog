<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Utility;

use Psr\Http\Message\ServerRequestInterface;
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

    public static function buildPersonData(Author $author, ServerRequestInterface $request): array
    {
        $url = '';
        $sameAs = [];
        if ($author->getProfile() !== '') {
            $url = GeneralUtility::locationHeaderUrl($author->getProfile(), $request);
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

        $imageUrl = self::getImageUrl($author, $request);
        if ($imageUrl !== '') {
            $data['image'] = $imageUrl;
        }

        if ($author->getWebsite() !== '') {
            $sameAs[] = GeneralUtility::locationHeaderUrl($author->getWebsite(), $request);
        }
        $twitterUrl = TwitterXUtility::getXUrl($author->getTwitter());
        if ($twitterUrl !== '') {
            $sameAs[] = $twitterUrl;
        }
        if ($author->getLinkedin() !== '') {
            $sameAs[] = GeneralUtility::locationHeaderUrl($author->getLinkedin(), $request);
        }
        if ($author->getXing() !== '') {
            $sameAs[] = GeneralUtility::locationHeaderUrl($author->getXing(), $request);
        }
        if ($author->getInstagram() !== '') {
            $sameAs[] = GeneralUtility::locationHeaderUrl($author->getInstagram(), $request);
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

    private static function getImageUrl(Author $author, ServerRequestInterface $request): string
    {
        $image = $author->getImage();
        if ($image === null) {
            return '';
        }

        $publicUrl = $image->getOriginalResource()->getPublicUrl();
        if ($publicUrl === null) {
            return '';
        }

        return GeneralUtility::locationHeaderUrl($publicUrl, $request);
    }
}
