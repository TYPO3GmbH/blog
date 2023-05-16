<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service;

use T3G\AgencyPack\Blog\TitleTagProvider\BlogTitleTagProvider;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class MetaTagService.
 */
class MetaTagService
{
    // Page Title
    public const META_TITLE = 'title';

    // Description
    public const META_DESCRIPTION = 'description';

    /**
     * @param string $type
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public static function set(string $type, string $value): void
    {
        switch ($type) {
            case self::META_TITLE:
                self::setTitle($value);
                break;
            case self::META_DESCRIPTION:
                self::setDescription($value);
                break;
            default:
                throw new \InvalidArgumentException('The type "' . $type . '" is not supported.', 1562020008);
        }
    }

    /**
     * @param string $value
     * @return void
     */
    protected static function setTitle(string $value): void
    {
        $provider = GeneralUtility::makeInstance(BlogTitleTagProvider::class);
        $provider->setTitle($value);
        $ogTitleManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('og:title');
        $ogTitleManager->addProperty('og:title', $value);
        $twitterTitleManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('twitter:title');
        $twitterTitleManager->addProperty('twitter:title', $value);
    }

    /**
     * @param string $value
     * @return void
     */
    protected static function setDescription(string $value): void
    {
        $descriptionManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('description');
        $descriptionManager->addProperty('description', $value);
        $ogDescriptionManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('og:description');
        $ogDescriptionManager->addProperty('og:description', $value);
        $twitterDescriptionManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('twitter:description');
        $twitterDescriptionManager->addProperty('twitter:description', $value);
    }
}
