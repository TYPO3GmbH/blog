<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog;

class Constants
{
    /**
     * Named constants for "magic numbers" of the field pages.doktype.
     */
    public const DOKTYPE_BLOG_POST = 137;
    public const DOKTYPE_BLOG_PAGE = 138;

    /**
     * Named constants for "magic numbers" of the field sys_category.category_type.
     */
    public const CATEGORY_TYPE_DEFAULT = 1;
    public const CATEGORY_TYPE_BLOG = 100;

    public const REPOSITORY_CONJUNCTION_OR = 'OR';
    public const REPOSITORY_CONJUNCTION_AND = 'AND';

    /**
     * Mapping is completly made up random numbers, up to ensure
     * we are not passing strings to the ContentObjectRenderer
     * when we are rendering fake content elements on blog pages.
     *
     * We need fake content elements to ensure the rendering
     * behaves on the container like every other content element.
     *
     * EXAMPLE:
     * {blogvh:data.contentListOptions(listType: 'blog_sidebar')}
     * <f:cObject typoscriptObjectPath="tt_content.list" data="{contentObjectData}" table="tt_content"/>
     *
     * USAGE:
     * Resources/Private/Templates/Page/BlogList.html
     * Resources/Private/Templates/Page/BlogPost.html
     *
     * NOTE:
     * Numbers need to be negative to ensure records do not exit.
     */
    public const LISTTYPE_TO_FAKE_UID_MAPPING = [
        'blog_posts'                => -1600000000,
        'blog_demandedposts'        => -1600000001,
        'blog_latestposts'          => -1600000002,
        'blog_category'             => -1600000003,
        'blog_authorposts'          => -1600000004,
        'blog_archive'              => -1600000005,
        'blog_sidebar'              => -1600000006,
        'blog_commentform'          => -1600000007,
        'blog_comments'             => -1600000008,
        'blog_header'               => -1600000009,
        'blog_footer'               => -1600000010,
        'blog_authors'              => -1600000012,
        'blog_relatedposts'         => -1600000013,
        'blog_recentpostswidget'    => -1600000014,
        'blog_categorywidget'       => -1600000015,
        'blog_tagwidget'            => -1600000016,
        'blog_commentswidget'       => -1600000017,
        'blog_archivewidget'        => -1600000018,
        'blog_feedwidget'           => -1600000019,
    ];
}
