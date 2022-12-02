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
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class ImageProvider implements AvatarProviderInterface
{
    public function getAvatarUrl(Author $author): string
    {
        $image = $author->getImage();
        if ($image instanceof FileReference) {
            $defaultSize = 32;
            $settings = [];
            $frontendController = self::getTypoScriptFrontendController();
            if ($frontendController instanceof TypoScriptFrontendController) {
                $settings = $frontendController->tmpl->setup['plugin.']['tx_blog.']['settings.'] ?? [];
            }
            $size = ($settings['authors.']['avatar.']['provider.']['size'] ?? $defaultSize) ?: $defaultSize;

            $imageService = GeneralUtility::makeInstance(ImageService::class);
            $image = $imageService->getImage('', $image, false);

            if ($image->hasProperty('crop') && $image->getProperty('crop')) {
                $cropString = $image->getProperty('crop');
            }
            $cropVariantCollection = CropVariantCollection::create((string)$cropString);
            $cropArea = $cropVariantCollection->getCropArea('default');

            $processingInstructions = [
                'width' => $size . 'c',
                'height' => $size,
                'minWidth' => $size,
                'minHeight' => $size,
                'crop' => $cropArea->isEmpty() ? null : $cropArea->makeAbsoluteBasedOnFile($image),
            ];
            $processedImage = $imageService->applyProcessingInstructions($image, $processingInstructions);
            return $imageService->getImageUri($processedImage);
        }
        return '';
    }

    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
