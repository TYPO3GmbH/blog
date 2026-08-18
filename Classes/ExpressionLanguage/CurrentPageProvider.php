<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ExpressionLanguage;

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Keeps the resolved frontend page record accessible for TypoScript conditions.
 *
 * TypoScript is compiled while the request is still travelling through the
 * middleware stack, so no request object is available to the condition provider.
 */
class CurrentPageProvider implements SingletonInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $pageRecord = [];

    /**
     * @param array<string, mixed> $pageRecord
     */
    public function setPageRecord(array $pageRecord): void
    {
        $this->pageRecord = $pageRecord;
    }

    /**
     * @return array<string, mixed>
     */
    public function getPageRecord(): array
    {
        return $this->pageRecord;
    }
}
