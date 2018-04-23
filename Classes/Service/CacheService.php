<?php

namespace T3G\AgencyPack\Blog\Service;

use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CacheService
 */
class CacheService
{
    /**
     * @param Post $post
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function addTagsForPost(Post $post)
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

    /**
     * @param string $tag
     */
    public function addTagToPage(string $tag)
    {
        $this->addTagsToPage([$tag]);
    }

    /**
     * @param array $tags
     */
    public function addTagsToPage(array $tags)
    {
        $this->getTypoScriptFrontendController()->addCacheTags($tags);
    }

    /**
     * @param string $tag
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    public function flushCacheByTag(string $tag)
    {
        $this->flushCacheByTags([$tag]);
    }

    /**
     * @param array $tags
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    public function flushCacheByTags(array $tags)
    {
        GeneralUtility::makeInstance(CacheManager::class)
            ->getCache('cache_pages')
            ->flushByTags($tags);
    }

    /**
     * @return mixed|\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
