<?php

namespace T3G\AgencyPack\Blog\AvatarProvider;

use T3G\AgencyPack\Blog\AvatarProviderInterface;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
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
 * Class ImageProvider.
 */
class ImageProvider implements AvatarProviderInterface
{
    /**
     * @param Author $author
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getAvatarUrl(Author $author)
    {
        $image = $author->getImage();
        if ($image instanceof FileReference) {
            return $author->getImage()->getOriginalResource()->getPublicUrl();
        }
        return '';
    }
}
