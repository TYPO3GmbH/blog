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

/**
 * Class GravatarProvider.
 */
class GravatarProvider implements AvatarProviderInterface
{
    /**
     * @param Author $author
     * @return string
     */
    public function getAvatarUrl(Author $author): string
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');

        $defaultSize = 32;
        $defaultDefault = 'mm';
        $defaultRating = 'g';
        $size = ($settings['authors']['avatar']['provider']['size'] ?? $defaultSize) ?: $defaultSize;
        $default = ($settings['authors']['avatar']['provider']['default'] ?? $defaultDefault) ?: $defaultDefault;
        $rating = ($settings['authors']['avatar']['provider']['rating'] ?? $defaultRating) ?: $defaultRating;

        $avatarUrl = 'https://www.gravatar.com/avatar/' . md5($author->getEmail())
            . '?s=' . $size
            . '&d=' . urlencode($default)
            . '&r=' . $rating;

        return $avatarUrl;
    }
}
