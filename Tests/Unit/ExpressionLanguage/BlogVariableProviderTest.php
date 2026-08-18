<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\ExpressionLanguage;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\Constants;
use T3G\AgencyPack\Blog\ExpressionLanguage\BlogVariableProvider;
use T3G\AgencyPack\Blog\ExpressionLanguage\CurrentPageProvider;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class BlogVariableProviderTest extends UnitTestCase
{
    /**
     * @return array<string, array{0: array<string, mixed>, 1: bool, 2: bool}>
     */
    public static function pageRecordDataProvider(): array
    {
        return [
            'blog post' => [['doktype' => Constants::DOKTYPE_BLOG_POST], true, false],
            'blog page' => [['doktype' => Constants::DOKTYPE_BLOG_PAGE], false, true],
            'doktype as string' => [['doktype' => (string)Constants::DOKTYPE_BLOG_POST], true, false],
            'standard page' => [['doktype' => 1], false, false],
            'page without doktype' => [[], false, false],
        ];
    }

    /**
     * @param array<string, mixed> $pageRecord
     */
    #[Test]
    #[DataProvider('pageRecordDataProvider')]
    public function doktypeOfResolvedPageIsDetected(array $pageRecord, bool $isPost, bool $isPage): void
    {
        $currentPageProvider = new CurrentPageProvider();
        $currentPageProvider->setPageRecord($pageRecord);

        $subject = new BlogVariableProvider($currentPageProvider);

        self::assertSame($isPost, $subject->isPost());
        self::assertSame($isPage, $subject->isPage());
    }

    #[Test]
    public function noResolvedPageEvaluatesToFalse(): void
    {
        $subject = new BlogVariableProvider(new CurrentPageProvider());

        self::assertFalse($subject->isPost());
        self::assertFalse($subject->isPage());
    }
}
