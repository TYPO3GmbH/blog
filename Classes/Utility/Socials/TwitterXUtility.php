<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Utility\Socials;

class TwitterXUtility
{
    public static function getXUrl(string $twitterXProfile): string
    {
        $twitterXProfile = trim($twitterXProfile);
        if ($twitterXProfile === '') {
            return '';
        }
        // url
        if (str_starts_with($twitterXProfile, 'http://') || str_starts_with($twitterXProfile, 'https://')) {
            $url = str_replace(['http://', 'twitter.com'], ['https://', 'x.com'], $twitterXProfile);
            if (!in_array(parse_url($url, PHP_URL_HOST), ['x.com', 'www.x.com'], true)) {
                // prevent other domains from passing
                return '';
            }
            return $url;
        }
        // username/handle
        return 'https://x.com/' . ltrim($twitterXProfile, '@');
    }
}
