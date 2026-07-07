<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Schema;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Domain\Model\Post;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class BlogPostingViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('post', Post::class, 'The blog post', true);
        $this->registerArgument('url', 'string', 'The absolute post URL', true);
        $this->registerArgument('publisherName', 'string', 'The publisher organization name');
        $this->registerArgument('publisherLogoUrl', 'string', 'The absolute publisher logo URL');
    }

    public function render(): string
    {
        /** @var Post $post */
        $post = $this->arguments['post'];
        $url = trim((string)$this->arguments['url']);

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            '@id' => $url,
            'headline' => $post->getTitle(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $url,
            ],
        ];

        $description = trim($post->getDescription()) !== '' ? $post->getDescription() : $post->getAbstract();
        if (trim($description) !== '') {
            $data['description'] = trim(strip_tags($description));
        }

        if ($post->getPublishDate() > 0) {
            $data['datePublished'] = date(DATE_ATOM, $post->getPublishDate());
        }
        if ($post->getTstamp() > 0) {
            $data['dateModified'] = date(DATE_ATOM, $post->getTstamp());
        }

        $imageUrl = $this->getFeaturedImageUrl($post);
        if ($imageUrl !== '') {
            $data['image'] = [
                '@type' => 'ImageObject',
                'url' => $imageUrl,
            ];
        }

        $publisherName = trim((string)($this->arguments['publisherName'] ?? ''));
        if ($publisherName === '') {
            $publisherName = $this->getPublisherNameFromSiteSettings();
        }
        $publisherLogoUrl = trim((string)($this->arguments['publisherLogoUrl'] ?? ''));
        if ($publisherName !== '') {
            $data['publisher'] = [
                '@type' => 'Organization',
                'name' => $publisherName,
            ];
            if ($publisherLogoUrl !== '') {
                $data['publisher']['logo'] = [
                    '@type' => 'ImageObject',
                    'url' => $publisherLogoUrl,
                ];
            }
        }

        $authors = [];
        foreach ($post->getAuthors() as $author) {
            $authors[] = PersonViewHelper::buildPersonData($author);
        }
        if ($authors !== []) {
            $data['author'] = count($authors) === 1 ? $authors[0] : $authors;
        }

        return (string)json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function getFeaturedImageUrl(Post $post): string
    {
        $featuredImage = $post->getFeaturedImage();
        if ($featuredImage === null) {
            return '';
        }

        $publicUrl = $featuredImage->getOriginalResource()->getPublicUrl();
        if ($publicUrl === null) {
            return '';
        }

        return GeneralUtility::locationHeaderUrl($publicUrl);
    }

    private function getPublisherNameFromSiteSettings(): string
    {
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        if (!$request instanceof ServerRequestInterface) {
            return '';
        }

        $site = $request->getAttribute('site');
        if (!$site instanceof Site) {
            return '';
        }

        return trim((string)($site->getSettings()->get('page.theme.contact.data.title') ?? ''));
    }
}
