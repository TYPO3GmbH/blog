<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Functional\ExpressionLanguage;

use Doctrine\DBAL\ParameterType;
use PHPUnit\Framework\Attributes\DataProvider;
use T3G\AgencyPack\Blog\Tests\Functional\SiteBasedTestCase;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;

class BlogExpressionsTest extends SiteBasedTestCase
{
    private const BLOG_PAGE_UID = 7;
    private const BLOG_POST_UID = 8;
    private const STRING_TO_TEST = 'expression is true';

    public static function typoScriptDataProvider(): array
    {
        $suffix = sprintf("\npage.10.value = %s\n[end]", self::STRING_TO_TEST);

        return [
            // positive tests
            'blog.isPage() is met' => [
                'pid' => self::BLOG_PAGE_UID,
                'typoScript' => sprintf('[blog.isPage()]%s', $suffix),
                'expectConditionToBeMet' => true,
            ],
            'blog.isPost() is met' => [
                'pid' => self::BLOG_POST_UID,
                'typoScript' => sprintf('[blog.isPost()]%s', $suffix),
                'expectConditionToBeMet' => true,
            ],
            'isBlogPage() is met' => [
                'pid' => self::BLOG_PAGE_UID,
                'typoScript' => sprintf('[isBlogPage()]%s', $suffix),
                'expectConditionToBeMet' => true,
            ],
            'isBlogPost() is met' => [
                'pid' => self::BLOG_POST_UID,
                'typoScript' => sprintf('[isBlogPost()]%s', $suffix),
                'expectConditionToBeMet' => true,
            ],

            // negative tests
            'blog.isPage() is not met' => [
                'pid' => self::ROOT_UID,
                'typoScript' => sprintf('[blog.isPage()]%s', $suffix),
                'expectConditionToBeMet' => false,
            ],
            'blog.isPost() is not met' => [
                'pid' => self::BLOG_PAGE_UID,
                'typoScript' => sprintf('[blog.isPost()]%s', $suffix),
                'expectConditionToBeMet' => false,
            ],
            'isBlogPage() is not met' => [
                'pid' => self::BLOG_POST_UID,
                'typoScript' => sprintf('[isBlogPage()]%s', $suffix),
                'expectConditionToBeMet' => false,
            ],
            'isBlogPost() is not met' => [
                'pid' => self::ROOT_UID,
                'typoScript' => sprintf('[isBlogPost()]%s', $suffix),
                'expectConditionToBeMet' => false,
            ],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->createTestSite();
    }

    #[DataProvider('typoScriptDataProvider')]
    public function testTypScriptConditions(int $pid, string $typoScript, bool $expectConditionToBeMet): void
    {
        $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('sys_template');
        $affectedRows = $queryBuilder
            ->update('sys_template')
            ->set(
                'config',
                $queryBuilder->getConnection()->getDatabasePlatform()->getConcatExpression(
                    $queryBuilder->quoteIdentifier('config'),
                    $queryBuilder->createNamedParameter("\n" . $typoScript)
                ),
                false
            )
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid, ParameterType::INTEGER))
            )
            ->executeStatement();

        if ($affectedRows !== 1) {
            throw new \RuntimeException('Unexpected fixture state.', 1787143116);
        }

        $response = (string)$this->executeFrontendSubRequest((new InternalRequest(SiteBasedTestCase::BASE_URL))
            ->withPageId($pid))
            ->getBody();

        if ($expectConditionToBeMet) {
            self::assertStringContainsString(self::STRING_TO_TEST, $response);
        } else {
            self::assertStringNotContainsString(self::STRING_TO_TEST, $response);
        }
    }
}
