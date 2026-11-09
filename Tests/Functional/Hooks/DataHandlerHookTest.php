<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\Hooks;

use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class DataHandlerHookTest extends FunctionalTestCase
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
        $this->importCSVDataSet(__DIR__ . '/Fixtures/BlogBasePages.csv');

        $data = [
            'pages' => [
                'NEW_blogPost1' => [
                    'pid' => 2,
                    'hidden' => 0,
                    'title' => 'Post 1',
                    'doktype' => Constants::DOKTYPE_BLOG_POST,
                    'publish_date' => 1689811200,
                    'crdate_month' => 0,
                    'crdate_year' => 0,
                ],
                'NEW_blogPage1' => [
                    'pid' => 1,
                    'hidden' => 0,
                    'title' => 'Page 1',
                    'doktype' => Constants::DOKTYPE_BLOG_PAGE,
                    'publish_date' => 1689811200,
                    'crdate_month' => 0,
                    'crdate_year' => 0,
                ]
            ]
        ];

        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->start($data, []);
        $dataHandler->process_datamap();

        /** @var array $post */
        $post = BackendUtility::getRecord('pages', 3);
        self::assertEquals($post['title'], 'Post 1');
        self::assertEquals($post['doktype'], Constants::DOKTYPE_BLOG_POST);
        self::assertEquals($post['crdate_month'], 7);
        self::assertEquals($post['crdate_year'], 2023);

        /** @var array $page */
        $page = BackendUtility::getRecord('pages', 4);
        self::assertEquals($page['title'], 'Page 1');
        self::assertEquals($page['doktype'], Constants::DOKTYPE_BLOG_PAGE);
        self::assertEquals($page['crdate_month'], 7);
        self::assertEquals($page['crdate_year'], 2023);
    }

    #[Test]
    public function update(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/BlogBasePages.csv');
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);

        // Initial
        $initial = [
            'pages' => [
                'NEW_blogPost1' => [
                    'pid' => 2,
                    'hidden' => 0,
                    'title' => 'Post 1',
                    'doktype' => Constants::DOKTYPE_BLOG_POST,
                    'publish_date' => 1689811200,
                    'crdate_month' => 0,
                    'crdate_year' => 0,
                ],
            ]
        ];
        $dataHandler->start($initial, []);
        $dataHandler->process_datamap();

        /** @var array $initialRecord */
        $initialRecord = BackendUtility::getRecord('pages', 3);
        self::assertEquals($initialRecord['title'], 'Post 1');
        self::assertEquals($initialRecord['doktype'], Constants::DOKTYPE_BLOG_POST);
        self::assertEquals($initialRecord['crdate_month'], 7);
        self::assertEquals($initialRecord['crdate_year'], 2023);

        // Update
        $update = [
            'pages' => [
                3 => [
                    'publish_date' => 1653004800,
                ],
            ]
        ];
        $dataHandler->start($update, []);
        $dataHandler->process_datamap();

        /** @var array $updateRecord */
        $updateRecord = BackendUtility::getRecord('pages', 3);
        self::assertEquals($updateRecord['title'], 'Post 1');
        self::assertEquals($updateRecord['doktype'], Constants::DOKTYPE_BLOG_POST);
        self::assertEquals($updateRecord['crdate_month'], 5);
        self::assertEquals($updateRecord['crdate_year'], 2022);
    }
}
