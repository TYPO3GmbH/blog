<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Utility\Socials;

class MastodonUtility
{
    public static function getMastodonUrl(string $mastodonProfile): string
    {
        $mastodonProfile = trim($mastodonProfile);
        if ($mastodonProfile === '') {
            return '';
        }
        if (str_starts_with($mastodonProfile, 'http://') || str_starts_with($mastodonProfile, 'https://')) {
            return $mastodonProfile;
        }
        if (str_starts_with($mastodonProfile, '@') && substr_count($mastodonProfile, '@') === 2) {
            [$username, $host] = explode('@', ltrim($mastodonProfile, '@'), 2);
            return 'https://' . $host . '/@' . $username;
        }
        return '';
    }

    public static function getMastodonHandle(string $mastodonProfile): string
    {
        $mastodonProfile = trim($mastodonProfile);
        if ($mastodonProfile === '') {
            return '';
        }
        if (str_starts_with($mastodonProfile, '@') && substr_count($mastodonProfile, '@') === 2) {
            return $mastodonProfile;
        }

        $parts = parse_url($mastodonProfile);
        if (!is_array($parts) || ($parts['host'] ?? '') === '' || ($parts['path'] ?? '') === '') {
            return '';
        }

        $username = trim((string)$parts['path'], '/');
        if (!str_starts_with($username, '@') || str_contains($username, '/')) {
            return '';
        }

        return $username . '@' . $parts['host'];
    }
}
