<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional;

use TYPO3\CMS\Core\Configuration\SiteWriter;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

abstract class SiteBasedTestCase extends FunctionalTestCase
{
    const BASE_URL = 'https://test.typo3.com/';
    const ROOT_UID = 1;
    const STORAGE_UID = 2;

    protected array $coreExtensionsToLoad = [
        'fluid_styled_content'
    ];

    protected array $testExtensionsToLoad = [
        'typo3conf/ext/blog'
    ];

    protected function createTestSite(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Site/pages.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Site/sys_template.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Site/tt_content.csv');

        $identifier = 'test';
        $configuration = [
            'websiteTitle' => 'Simple Test Site',
            'rootPageId' => '1',
            'base' => self::BASE_URL,
            'languages' => [
                [
                    'title' => 'English',
                    'enabled' => true,
                    'languageId' => 0,
                    'base' => '/',
                    'typo3Language' => 'default',
                    'locale' => 'en_US.UTF-8',
                    'iso-639-1' => 'en',
                    'navigationTitle' => 'English',
                    'hreflang' => 'en-us',
                    'direction' => 'ltr',
                    'flag' => 'us'
                ]
            ],
            'imports' => [
                [
                    'resource' => 'EXT:blog/Configuration/Routes/Default.yaml'
                ]
            ]
        ];

        GeneralUtility::rmdir($this->instancePath . '/typo3conf/sites/' . $identifier, true);
        $this->get(SiteWriter::class)->write($identifier, $configuration);
    }

    protected function renderFluidTemplateInTestSite(string $template, array $instructions = []): string
    {
        $instructionString = '';
        foreach ($instructions as $key => $values) {
            $instructionString .= "\n";
            foreach ($values as $name => $value) {
                $instructionString .= "\n" . $key . '.' . $name . ' = ' . $value;
            }
        }

        (new ConnectionPool())->getConnectionForTable('pages')->delete('pages', ['uid' => 9999]);
        (new ConnectionPool())->getConnectionForTable('pages')->insert(
            'pages',
            [
                'uid' => 9999,
                'pid' => 1,
                'doktype' => 1,
                'title' => 'Template Test',
                'slug' => '/template-test'
            ]
        );
        (new ConnectionPool())->getConnectionForTable('sys_template')->delete('sys_template', ['uid' => 9999]);
        (new ConnectionPool())->getConnectionForTable('sys_template')->insert(
            'sys_template',
            [
                'uid' => 9999,
                'pid' => 9999,
                'config' => implode("\n", [
                    'page >',
                    'page = PAGE',
                    'page.config.disableAllHeaderCode = 1',
                    'page.10 = FLUIDTEMPLATE',
                    'page.10 {',
                    '    template = TEXT',
                    '    template.value = ' . $template,
                    '    extbase.pluginName = Posts',
                    '    extbase.controllerExtensionName = Blog',
                    '    extbase.controllerName = Posts',
                    '    extbase.controllerActionName = listRecentPosts',
                    '    dataProcessing {',
                    '       1 = T3G\AgencyPack\Blog\Tests\Functional\Helpers\TestDataProcessor',
                    '       1 {',
                    '           data {',
                    '               ' . $instructionString,
                    '           }',
                    '       }',
                    '    }',
                    '}'
                ])
            ]
        );
        $response = $this->executeFrontendSubRequest((new InternalRequest(self::BASE_URL . 'template-test')));

        return trim((string) $response->getBody());
    }
}
