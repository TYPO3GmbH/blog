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
use T3G\AgencyPack\Blog\Fractor\V14\MigrateTypoScriptBlogIsPageExpressionFractor;
use T3G\AgencyPack\Blog\Fractor\V14\MigrateTypoScriptBlogIsPostExpressionFractor;

/**
 * BlogVariableProvider
 */
#[Autoconfigure(public: true)]
readonly class BlogVariableProvider
{
    public function __construct(
        protected CurrentPageProvider $currentPageProvider
    ) {
    }

    public function isPost(): bool
    {
        trigger_error(
            sprintf(
                'Using the old TypoScript condition blog.isPost() is deprecated. Please migrate to isBlogPost(). There is a typo3-fractor rule available at %s.',
                MigrateTypoScriptBlogIsPostExpressionFractor::class
            ),
            E_USER_DEPRECATED
        );

        return $this->isDoktype(Constants::DOKTYPE_BLOG_POST);
    }

    public function isPage(): bool
    {
        trigger_error(
            sprintf(
                'Using the old TypoScript condition blog.isPage() is deprecated. Please migrate to isBlogPage(). There is a typo3-fractor rule available at %s.',
                MigrateTypoScriptBlogIsPageExpressionFractor::class
            ),
            E_USER_DEPRECATED
        );

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
