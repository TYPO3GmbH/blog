<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Hooks;

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Hooks\CreateSiteConfiguration as CoreCreateSiteConfiguration;

class CreateSiteConfigurationHook extends CoreCreateSiteConfiguration
{
    protected $allowedPageTypes = [
        PageRepository::DOKTYPE_DEFAULT,
        PageRepository::DOKTYPE_LINK,
        PageRepository::DOKTYPE_SHORTCUT,
        Constants::DOKTYPE_BLOG_PAGE
    ];
}
