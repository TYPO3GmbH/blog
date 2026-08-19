<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Listener;

use T3G\AgencyPack\Blog\ExpressionLanguage\CurrentPageProvider;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Event\AfterPageAndLanguageIsResolvedEvent;

#[AsEventListener(identifier: 't3g/blog/provide-current-page-to-conditions')]
readonly class ProvideCurrentPageToConditions
{
    public function __construct(
        protected CurrentPageProvider $currentPageProvider
    ) {
    }

    public function __invoke(AfterPageAndLanguageIsResolvedEvent $event): void
    {
        $this->currentPageProvider->setPageRecord($event->getPageInformation()->getPageRecord());
    }
}
