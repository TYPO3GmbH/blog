<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service;

use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class CacheService
 */
class CacheService
{
    public function addTagsForPost(Post $post): void
    {
        $this->addTagToPage('tx_blog_post_' . $post->getUid());
        foreach ($post->getAuthors() as $author) {
            $this->addTagToPage('tx_blog_author_' . $author->getUid());
        }
        foreach ($post->getCategories() as $category) {
            $this->addTagToPage('tx_blog_category_' . $category->getUid());
        }
        foreach ($post->getTags() as $tag) {
            $this->addTagToPage('tx_blog_tag_' . $tag->getUid());
        }
        foreach ($post->getActiveComments() as $comment) {
            $this->addTagToPage('tx_blog_comment_' . $comment->getUid());
        }
    }

    public function addTagToPage(string $tag): void
    {
        $this->addTagsToPage([$tag]);
    }

    public function addTagsToPage(array $tags): void
    {
        $this->getTypoScriptFrontendController()->addCacheTags($tags);
    }

    public function flushCacheByTag(string $tag): void
    {
        $this->flushCacheByTags([$tag]);
    }

    public function flushCacheByTags(array $tags): void
    {
        GeneralUtility::makeInstance(CacheManager::class)
            ->getCache('pages')
            ->flushByTags($tags);
    }

    protected function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
