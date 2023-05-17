<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\Helpers;

use T3G\AgencyPack\Blog\Domain\Repository\AuthorRepository;
use T3G\AgencyPack\Blog\Domain\Repository\CategoryRepository;
use T3G\AgencyPack\Blog\Domain\Repository\CommentRepository;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Domain\Repository\TagRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class TestDataProcessor implements DataProcessorInterface
{
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        $authorRepository = GeneralUtility::makeInstance(AuthorRepository::class);
        $categoryRepository = GeneralUtility::makeInstance(CategoryRepository::class);
        $commentRepository = GeneralUtility::makeInstance(CommentRepository::class);
        $postRepository = GeneralUtility::makeInstance(PostRepository::class);
        $tagRepository = GeneralUtility::makeInstance(TagRepository::class);

        $result = [];
        foreach ($processorConfiguration['data.'] as $config) {
            switch ($config['type']) {
                case 'author':
                    $result[$config['as']] = $authorRepository->findByUid($config['uid']);
                    break;
                case 'category':
                    $result[$config['as']] = $categoryRepository->findByUid($config['uid']);
                    break;
                case 'comment':
                    $result[$config['as']] = $commentRepository->findByUid($config['uid']);
                    break;
                case 'post':
                    $result[$config['as']] = $postRepository->findByUid($config['uid']);
                    break;
                case 'tag':
                    $result[$config['as']] = $tagRepository->findByUid($config['uid']);
                    break;
            }
        }

        $processedData['test'] = $result;
        return $processedData;
    }
}
