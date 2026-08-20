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
use T3G\AgencyPack\Blog\Utility\SchemaUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class BlogPostingViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('post', Post::class, 'The blog post', true);
    }

    public function render(): string
    {
        $request = $this->getRequest();
        /** @var Post $post */
        $post = $this->arguments['post'];
        $uri = GeneralUtility::makeInstance(UriBuilder::class)->reset()
            ->setRequest($request)
            ->setTargetPageUid((int)$post->getUid())
            ->setCreateAbsoluteUri(true)
            ->build();

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->getTitle(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $uri,
            ],
        ];

        $description = trim($post->getDescription()) !== '' ? $post->getDescription() : $post->getAbstract();
        if (trim($description) !== '') {
            $data['description'] = trim(htmlspecialchars(strip_tags($description)));
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

        $authors = [];
        foreach ($post->getAuthors() as $author) {
            $authorData = SchemaUtility::buildPersonData($author);
            if ($author->getDetailsPage() > 0) {
                $authorData['sameAs'][] = GeneralUtility::makeInstance(UriBuilder::class)->reset()
                    ->setRequest($request)
                    ->setTargetPageUid($author->getDetailsPage())
                    ->setCreateAbsoluteUri(true)
                    ->build();
            }
            $authors[] = $authorData;
        }
        if ($authors !== []) {
            $data['author'] = count($authors) === 1 ? $authors[0] : $authors;
        }

        return (string)json_encode($data, SchemaUtility::JSON_ENCODE_OPTIONS);
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

    protected function getRequest(): RequestInterface
    {
        if (null === $this->renderingContext) {
            throw new \RuntimeException('ViewHelper blogvh:schema.blogPosting requires an existing rendering context.', 1784623876);
        }
        $request = null;
        if ($this->renderingContext->hasAttribute(ServerRequestInterface::class)) {
            $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        }

        if (!$request instanceof RequestInterface) {
            throw new \RuntimeException(
                'ViewHelper blogvh:schema.blogPosting can be used only in extbase context and needs a request implementing extbase RequestInterface.',
                1784623877
            );
        }

        return $request;
    }
}
