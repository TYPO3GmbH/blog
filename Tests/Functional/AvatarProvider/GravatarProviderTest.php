<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\AvatarProvider;

use T3G\AgencyPack\Blog\AvatarProvider\GravatarProvider;
use T3G\AgencyPack\Blog\Domain\Model\Author;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\TypoScript\AST\Node\RootNode;
use TYPO3\CMS\Core\TypoScript\FrontendTypoScript;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class GravatarProviderTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'form'
    ];

    protected array $testExtensionsToLoad = [
        'typo3conf/ext/blog'
    ];

    public function testGetAvatarUrlReturnsOriginalGravatarComUrl(): void
    {
        /** @phpstan-ignore-next-line */
        $frontendTypoScript = new FrontendTypoScript(new RootNode(), [], [], []);
        $frontendTypoScript->setSetupArray([]);
        $request = (new ServerRequest())
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_FE)
            ->withAttribute('frontend.typoscript', $frontendTypoScript);
        $this->get(ConfigurationManagerInterface::class)->setRequest($request);

        $author = (new Author())->setEmail('name@host.tld');
        $gravatarProvider = new GravatarProvider();
        self::assertSame(
            'https://www.gravatar.com/avatar/71803b16fcdb8ac77611d0a977b20164?s=64',
            $gravatarProvider->getAvatarUrl($author, 64)
        );
    }

    public function testGetAvatarUrlReturnsTypo3TempUrl(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['blog']['enableGravatarProxy'] = '1';
        /** @phpstan-ignore-next-line */
        $frontendTypoScript = new FrontendTypoScript(new RootNode(), [], [], []);
        $frontendTypoScript->setSetupArray([]);
        $request = (new ServerRequest())
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_FE)
            ->withAttribute('frontend.typoscript', $frontendTypoScript);
        $this->get(ConfigurationManagerInterface::class)->setRequest($request);

        $author = (new Author())->setEmail('name@host.tld');
        $gravatarProvider = new GravatarProvider();
        self::assertStringContainsString(
            'typo3temp/assets/t3g/blog/gravatar/',
            $gravatarProvider->getAvatarUrl($author, 64)
        );
    }
}
