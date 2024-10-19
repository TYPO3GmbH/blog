<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;

$data = [];

// Pages
$data['pages']['NEW_blogRoot'] = [
    'pid' => 0,
    'hidden' => 1,
    'title' => 'Blog',
    'doktype' => Constants::DOKTYPE_BLOG_PAGE,
    'is_siteroot' => 1,
    'TSconfig' => 'TCEFORM.pages.tags.PAGE_TSCONFIG_ID = NEW_blogFolder
TCEFORM.pages.authors.PAGE_TSCONFIG_ID = NEW_blogFolder
TCEFORM.pages.categories.PAGE_TSCONFIG_ID = NEW_blogFolder
TCEFORM.tt_content.pi_flexform.blog_demandedposts.sDEF.settings\.demand\.authors.PAGE_TSCONFIG_ID = NEW_blogFolder
TCEFORM.tt_content.pi_flexform.blog_demandedposts.sDEF.settings\.demand\.tags.PAGE_TSCONFIG_ID = NEW_blogFolder
TCEFORM.tt_content.pi_flexform.blog_demandedposts.sDEF.settings\.demand\.categories.PAGE_TSCONFIG_ID = NEW_blogFolder',
];
$data['pages']['NEW_blogFolder'] = [
    'pid' => 'NEW_blogRoot',
    'hidden' => 0,
    'title' => 'Data',
    'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
    'module' => 'blog'
];
$data['pages']['NEW_blogCategoryPage'] = [
    'pid' => '-NEW_blogFolder',
    'hidden' => 0,
    'title' => 'Category',
    'doktype' => Constants::DOKTYPE_BLOG_PAGE,
];
$data['pages']['NEW_blogTagPage'] = [
    'pid' => '-NEW_blogCategoryPage',
    'hidden' => 0,
    'title' => 'Tag',
    'doktype' => Constants::DOKTYPE_BLOG_PAGE,
];
$data['pages']['NEW_blogAuthorPage'] = [
    'pid' => '-NEW_blogTagPage',
    'hidden' => 0,
    'title' => 'Author',
    'doktype' => Constants::DOKTYPE_BLOG_PAGE,
];
$data['pages']['NEW_blogArchivePage'] = [
    'pid' => '-NEW_blogAuthorPage',
    'hidden' => 0,
    'title' => 'Archive',
    'doktype' => Constants::DOKTYPE_BLOG_PAGE,
];
$data['pages']['NEW_firstBlogPostPage'] = [
    'pid' => 'NEW_blogFolder',
    'hidden' => 0,
    'title' => 'First blog post',
    'doktype' => Constants::DOKTYPE_BLOG_POST,
    'abstract' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut consectetur quam. Ut rutrum augue libero, non rhoncus libero imperdiet vel. Pellentesque libero orci, porttitor sed dui vel, tempus sodales ex. Sed placerat lobortis tellus at tempus.'
];

// Template
$data['sys_template']['NEW_SysTemplate'] = [
    'pid' => 'NEW_blogRoot',
    'title' => 'Blog',
    'root' => 1,
    'clear' => 3,
    'include_static_file' => 'EXT:blog/Configuration/TypoScript/Standalone/',
    'constants' => 'plugin.tx_blog.settings.blogUid = NEW_blogRoot
plugin.tx_blog.settings.categoryUid = NEW_blogCategoryPage
plugin.tx_blog.settings.tagUid = NEW_blogTagPage
plugin.tx_blog.settings.authorUid = NEW_blogAuthorPage
plugin.tx_blog.settings.archiveUid = NEW_blogArchivePage
plugin.tx_blog.settings.storagePid = NEW_blogFolder',
    'config' => '',
    'description' => 'This is your blog template',
];

// Content elements
$data['tt_content']['NEW_ListOfPosts'] = [
    'pid' => 'NEW_blogRoot',
    'CType' => 'blog_posts',
];
$data['tt_content']['NEW_ListByCategory'] = [
    'pid' => 'NEW_blogCategoryPage',
    'CType' => 'blog_category',
];
$data['tt_content']['NEW_ListByTag'] = [
    'pid' => 'NEW_blogTagPage',
    'CType' => 'blog_tag',
];
$data['tt_content']['NEW_ListByAuthor'] = [
    'pid' => 'NEW_blogAuthorPage',
    'CType' => 'blog_authorposts',
];
$data['tt_content']['NEW_ListByDate'] = [
    'pid' => 'NEW_blogArchivePage',
    'CType' => 'blog_archive',
];

// Content
$data['tt_content']['NEW_BlogPostContentThird'] = [
    'pid' => 'NEW_firstBlogPostPage',
    'CType' => 'text',
    'header' => 'Third Content Block',
    'header_layout' => 3,
    'bodytext' => 'Phasellus at ornare arcu, vel lobortis magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed hendrerit tortor nisi, at iaculis eros dignissim ac. Praesent bibendum nibh vitae dictum tempus. Etiam elit nibh, tristique non velit a, malesuada feugiat nisi. Fusce at lacinia dolor. Curabitur sit amet leo massa. Curabitur tellus dui, fermentum luctus augue placerat, blandit blandit ante.',
];
$data['tt_content']['NEW_BlogPostContentSecond'] = [
    'pid' => 'NEW_firstBlogPostPage',
    'CType' => 'text',
    'header' => 'Second Content Block',
    'header_layout' => 3,
    'bodytext' => '<ul>'
        . '<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>'
        . '<li>Integer et eros at nulla rhoncus elementum id ac tortor.</li>'
        . '<li>Fusce ultrices ipsum vitae nisl vulputate aliquam.</li>'
        . '<li>In tempus augue sed diam tempus iaculis.</li>'
        . '<li>In interdum velit sed purus molestie hendrerit in ac justo.</li>'
        . '</ul>',
];
$data['tt_content']['NEW_BlogPostContentFirst'] = [
    'pid' => 'NEW_firstBlogPostPage',
    'CType' => 'text',
    'header' => 'First Content Block',
    'bodytext' => 'Sed vitae finibus sapien, ac sagittis nisi. Nam at quam sed ipsum convallis rhoncus. Sed eget erat fringilla, ultrices lorem in, luctus nunc. Sed aliquam congue odio, non fermentum metus consectetur in. Donec aliquet erat est, id eleifend nunc viverra sed. Vivamus tempus rutrum justo tempor dapibus. Integer scelerisque, est at lacinia tristique, est mauris bibendum tortor, sed malesuada mi augue nec orci. In dictum vitae purus eu facilisis. Morbi porta efficitur turpis. Curabitur vel erat magna. Vivamus finibus sapien sed ante euismod semper. Integer cursus lectus at ligula porttitor, blandit gravida urna suscipit. Vestibulum dictum eros pulvinar, vehicula lorem id, viverra neque. Phasellus maximus nisl a magna convallis imperdiet. In a quam dolor. Vestibulum auctor dolor lectus, vel faucibus odio efficitur in.',
];

// Categories
$data['sys_category']['NEW_blogCategoryRoot'] = [
    'pid' => 'NEW_blogFolder',
    'record_type' => Constants::CATEGORY_TYPE_BLOG,
    'title' => 'Blog',
];
$data['sys_category']['NEW_blogCategoryTYPO3'] = [
    'pid' => 'NEW_blogFolder',
    'record_type' => Constants::CATEGORY_TYPE_BLOG,
    'parent' => 'NEW_blogCategoryRoot',
    'title' => 'TYPO3',
];

// Tags
$data['tx_blog_domain_model_tag']['NEW_blogTagTYPO3'] = [
    'pid' => 'NEW_blogFolder',
    'title' => 'TYPO3',
];

// Author
$data['tx_blog_domain_model_author']['NEW_blogAuthor'] = [
    'pid' => 'NEW_blogFolder',
    'name' => 'TYPO3 Inc Team',
    'location' => 'Düsseldorf',
    'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim ornare nisi vitae.',
    'website' => 'https://typo3.com/',
    'email' => 'noreply@typo3.com',
    'twitter' => 'typo3',
    'instagram' => 'https://www.instagram.com/typo3_official/',
];

// Comment
$data['tx_blog_domain_model_comment']['NEW_blogComment'] = [
    'pid' => 'NEW_firstBlogPostPage',
    'status' => 10,
    'name' => 'TYPO3 Inc Team',
    'url' => 'https://typo3.com/',
    'email' => 'noreply@typo3.com',
    'comment' => 'Quisque vulputate, mauris eget tempus luctus, lorem ipsum interdum lorem, vitae maximus nulla est vel urna. In hac habitasse platea dictumst. Fusce lorem est, interdum vitae maximus sed, volutpat quis felis. Proin commodo velit sed rhoncus ornare. Ut a magna vitae est condimentum volutpat et ac ipsum. Nulla facilisi. Integer ut euismod felis. Aenean blandit eros neque.'
];

return $data;
