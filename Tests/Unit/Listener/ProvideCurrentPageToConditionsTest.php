<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests\Unit\Listener;

use PHPUnit\Framework\Attributes\Test;
use T3G\AgencyPack\Blog\ExpressionLanguage\CurrentPageProvider;
use T3G\AgencyPack\Blog\Listener\ProvideCurrentPageToConditions;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Frontend\Event\AfterPageAndLanguageIsResolvedEvent;
use TYPO3\CMS\Frontend\Page\PageInformation;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ProvideCurrentPageToConditionsTest extends UnitTestCase
{
    #[Test]
    public function resolvedPageRecordIsHandedOverToTheConditionProvider(): void
    {
        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord(['uid' => 42, 'doktype' => 137]);
        $currentPageProvider = new CurrentPageProvider();

        $subject = new ProvideCurrentPageToConditions($currentPageProvider);
        $subject(new AfterPageAndLanguageIsResolvedEvent(new ServerRequest(), $pageInformation));

        self::assertSame(['uid' => 42, 'doktype' => 137], $currentPageProvider->getPageRecord());
    }
}
