<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ExpressionLanguage;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use T3G\AgencyPack\Blog\Constants;

/**
 * BlogVariableProvider
 */
#[Autoconfigure(public: true)]
class BlogVariableProvider
{
    public function __construct(
        protected readonly CurrentPageProvider $currentPageProvider
    ) {
    }

    public function isPost(): bool
    {
        return $this->isDoktype(Constants::DOKTYPE_BLOG_POST);
    }

    public function isPage(): bool
    {
        return $this->isDoktype(Constants::DOKTYPE_BLOG_PAGE);
    }

    protected function isDoktype(int $doktype): bool
    {
        $page = $this->currentPageProvider->getPageRecord();
        if (!isset($page['doktype'])) {
            return false;
        }
        return (int)$page['doktype'] === $doktype;
    }
}
