<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\Service;

use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\Service\SetupService;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class SetupServiceTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'form'
    ];

    protected array $testExtensionsToLoad = [
        'typo3conf/ext/blog'
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->importCSVDataSet(__DIR__ . '/../Fixtures/DataHandler/be_users.csv');
        $backendUser = $this->setUpBackendUser(1);
        $GLOBALS['LANG'] = $this->get(LanguageServiceFactory::class)->createFromUserPreferences($backendUser);
    }

    #[Test]
    public function create(): void
    {
        $setupService = GeneralUtility::makeInstance(SetupService::class);
        $setupService->createBlogSetup();

        /** @var array $rootPage */
        $rootPage = BackendUtility::getRecord('pages', 1);
        self::assertEquals($rootPage['title'], 'Blog');
        self::assertEquals($rootPage['doktype'], Constants::DOKTYPE_BLOG_PAGE);
        self::assertEquals($rootPage['is_siteroot'], 1);
    }

    #[Test]
    public function createWithName(): void
    {
        $setupService = GeneralUtility::makeInstance(SetupService::class);
        $setupService->createBlogSetup(['title' => 'DEMO']);

        /** @var array $rootPage */
        $rootPage = BackendUtility::getRecord('pages', 1);
        self::assertEquals($rootPage['title'], 'DEMO');
        self::assertEquals($rootPage['doktype'], Constants::DOKTYPE_BLOG_PAGE);
        self::assertEquals($rootPage['is_siteroot'], 1);
    }

    #[Test]
    public function determineBlogSetups(): void
    {
        $setupService = GeneralUtility::makeInstance(SetupService::class);
        $setupService->createBlogSetup(['title' => 'TEST 1']);
        $setupService->createBlogSetup(['title' => 'TEST 2']);

        $blogSetups = $setupService->determineBlogSetups();

        $blogSetup1 = array_shift($blogSetups);
        self::assertEquals($blogSetup1['path'], 'TEST 1 / Data');
        $blogSetup2 = array_shift($blogSetups);
        self::assertEquals($blogSetup2['path'], 'TEST 2 / Data');
    }
}
