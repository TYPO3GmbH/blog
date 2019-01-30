<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\AvatarProvider;

use T3G\AgencyPack\Blog\AvatarProviderInterface;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class GravatarProvider implements AvatarProviderInterface
{
    public function getAvatarUrl(Author $author): string
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');

        $size = $settings['authors']['avatar']['provider']['size'] ?: 32;
        $default = $settings['authors']['avatar']['provider']['default'] ?: 'mm';
        $rating = $settings['authors']['avatar']['provider']['rating'] ?: 'g';

        $avatarUrl = 'https://www.gravatar.com/avatar/' . md5($author->getEmail())
            . '?s=' . $size
            . '&d=' . urlencode($default)
            . '&r=' . $rating;

        return $avatarUrl;
    }
}
