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
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class ImageProvider implements AvatarProviderInterface
{
    public function getAvatarUrl(Author $author): string
    {
        $image = $author->getImage();
        if ($image instanceof FileReference) {
            return $image->getOriginalResource()->getPublicUrl();
        }
        return '';
    }
}
