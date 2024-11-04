<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\CacheTag;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class CacheService
 */
class CacheService
{
    public function addTagsForPost(ServerRequestInterface $request, Post $post): void
    {
        $this->addTagToPage($request, 'tx_blog_post_' . $post->getUid());
        foreach ($post->getAuthors() as $author) {
            $this->addTagToPage($request, 'tx_blog_author_' . $author->getUid());
        }
        foreach ($post->getCategories() as $category) {
            $this->addTagToPage($request, 'tx_blog_category_' . $category->getUid());
        }
        foreach ($post->getTags() as $tag) {
            $this->addTagToPage($request, 'tx_blog_tag_' . $tag->getUid());
        }
        foreach ($post->getActiveComments() as $comment) {
            $this->addTagToPage($request, 'tx_blog_comment_' . $comment->getUid());
        }
    }

    public function addTagToPage(ServerRequestInterface $request, string $tag): void
    {
        $this->addTagsToPage($request, [$tag]);
    }

    public function addTagsToPage(ServerRequestInterface $request, array $tags): void
    {
        $request->getAttribute('frontend.cache.collector')->addCacheTags(
            ...array_map(fn(string $tag) => new CacheTag($tag), $tags)
        );
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
}
