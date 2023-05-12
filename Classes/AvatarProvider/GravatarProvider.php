<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\AvatarProvider;

use T3G\AgencyPack\Blog\Domain\Model\Author;
use T3G\AgencyPack\Blog\Http\Client;
use T3G\AgencyPack\Blog\Http\RequestFactory;
use T3G\AgencyPack\Blog\Http\UriFactory;
use T3G\AgencyPack\Blog\Service\Avatar\AvatarResourceResolverInterface;
use T3G\AgencyPack\Blog\Service\Avatar\Gravatar\GravatarResourceResolver;
use T3G\AgencyPack\Blog\Service\Avatar\Gravatar\GravatarUriBuilder;
use T3G\AgencyPack\Blog\Service\Avatar\Gravatar\GravatarUriBuilderInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class GravatarProvider implements AvatarProviderInterface, SingletonInterface
{
    /**
     * @var GravatarUriBuilderInterface
     */
    private $gravatarUriBuilder;

    /**
     * @var AvatarResourceResolverInterface
     */
    private $avatarResourceResolver;

    /**
     * @var bool
     */
    private $proxyGravatarImage;

    final public function __construct()
    {
        $this->gravatarUriBuilder = GeneralUtility::makeInstance(
            GravatarUriBuilder::class,
            GeneralUtility::makeInstance(UriFactory::class)
        );
        $this->avatarResourceResolver = GeneralUtility::makeInstance(
            GravatarResourceResolver::class,
            GeneralUtility::makeInstance(Client::class, GeneralUtility::makeInstance(\GuzzleHttp\Client::class)),
            GeneralUtility::makeInstance(RequestFactory::class)
        );

        /** @var ExtensionConfiguration $extensionConfiguration */
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $this->proxyGravatarImage = (bool)($extensionConfiguration->get('blog', 'enableGravatarProxy') ?? false);
    }

    public function getAvatarUrl(Author $author, int $size): string
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');

        $rating = empty($rating = (string)($settings['authors']['avatar']['provider']['rating'] ?? '')) ? null : $rating;
        $default = empty($default = (string)($settings['authors']['avatar']['provider']['default'] ?? '')) ? null : $default;

        $gravatarUri = $this->gravatarUriBuilder->getUri(
            $author->getEmail(),
            $size,
            $rating,
            $default
        );

        if (!$this->proxyGravatarImage) {
            return (string)$gravatarUri;
        }

        try {
            $gravatar = $this->avatarResourceResolver->resolve($gravatarUri);
        } catch (\Throwable $e) {
            // something went wrong, no need to deal with caching
            return '';
        }

        $fileType = $this->deriveFileTypeFromContentType($gravatar->getContentType());
        $filePath = Environment::getPublicPath() . '/typo3temp/assets/t3g/blog/gravatar/' . md5($gravatar->getContent()) . '.' . $fileType;

        $absoluteWebPath = PathUtility::getAbsoluteWebPath($filePath);

        if (file_exists($filePath)) {
            if (hash_equals(md5_file($filePath), md5($gravatar->getContent()))) {
                return $absoluteWebPath;
            }

            unlink($filePath);
        }

        $errorMessage = GeneralUtility::writeFileToTypo3tempDir($filePath, $gravatar->getContent());
        if ($errorMessage !== null && !file_exists($filePath)) {
            throw new \RuntimeException($errorMessage, 1597674070);
        }

        return $absoluteWebPath;
    }

    private function deriveFileTypeFromContentType(string $contentType): string
    {
        return substr($contentType, (int)strrpos($contentType, '/') + 1);
    }
}
