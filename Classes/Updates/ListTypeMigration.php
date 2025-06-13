<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

#[UpgradeWizard(ListTypeMigration::class)]
final class ListTypeMigration extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        $ctypes = [
            'blog_posts',
            'blog_latestposts',
            'blog_category',
            'blog_authorposts',
            'blog_tag',
            'blog_archive',
            'blog_sidebar',
            'blog_commentform',
            'blog_comments',
            'blog_authors',
            'blog_demandedposts',
            'blog_relatedposts',
            'blog_header',
            'blog_footer'
        ];
        return array_combine($ctypes, $ctypes);
    }

    public function getTitle(): string
    {
        return 'Migrate "t3g/blog" plugins to content elements.';
    }

    public function getDescription(): string
    {
        return 'The "blog" plugins will be registered as content elements. The update migrates existing records and backend user permissions.';
    }
}
