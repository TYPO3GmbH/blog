<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$data = [];

// Pages
$data['pages']['NEW_blogRoot'] = [
    'pid' => 0,
    'hidden' => 1,
    'title' => 'Blog',
    'doktype' => 1,
    'is_siteroot' => 1,
    'TSconfig' => 'TCEFORM.pages.tags.PAGE_TSCONFIG_ID = NEW_blogFolder
TCEFORM.pages.authors.PAGE_TSCONFIG_ID = NEW_blogFolder
TCEFORM.pages.categories.PAGE_TSCONFIG_ID = NEW_blogFolder',
];
$data['pages']['NEW_blogFolder'] = [
    'pid' => 'NEW_blogRoot',
    'hidden' => 0,
    'title' => 'Data',
    'doktype' => 254,
];
$data['pages']['NEW_blogCategoryPage'] = [
    'pid' => '-NEW_blogFolder',
    'hidden' => 0,
    'title' => 'Category',
    'doktype' => 1,
];
$data['pages']['NEW_blogTagPage'] = [
    'pid' => '-NEW_blogCategoryPage',
    'hidden' => 0,
    'title' => 'Tag',
    'doktype' => 1,
];
$data['pages']['NEW_blogAuthorPage'] = [
    'pid' => '-NEW_blogTagPage',
    'hidden' => 0,
    'title' => 'Author',
    'doktype' => 1,
];
$data['pages']['NEW_blogArchivePage'] = [
    'pid' => '-NEW_blogAuthorPage',
    'hidden' => 0,
    'title' => 'Archive',
    'doktype' => 1,
];
$data['pages']['NEW_firstBlogPostPage'] = [
    'pid' => 'NEW_blogFolder',
    'hidden' => 0,
    'title' => 'First blog post',
    'doktype' => \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST,
];

// Template
$data['sys_template']['NEW_SysTemplate'] = [
    'pid' => 'NEW_blogRoot',
    'title' => 'Blog',
    'sitetitle' => 'Blog with TYPO3',
    'root' => 1,
    'clear' => 3,
    'include_static_file' => 'EXT:fluid_styled_content/Configuration/TypoScript/,EXT:blog/Configuration/TypoScript/Static/',
    'constants' => 'plugin.tx_blog.settings.blogUid = NEW_blogRoot
plugin.tx_blog.settings.categoryUid = NEW_blogCategoryPage
plugin.tx_blog.settings.tagUid = NEW_blogTagPage
plugin.tx_blog.settings.authorUid = NEW_blogAuthorPage
plugin.tx_blog.settings.archiveUid = NEW_blogArchivePage
plugin.tx_blog.settings.storagePid = NEW_blogFolder',
    'config' => 'page = PAGE
page.10 < styles.content.get',
    'description' => 'This is your blog template',
];

// Content elements
$data['tt_content']['NEW_ListOfPosts'] = [
    'pid' => 'NEW_blogRoot',
    'CType' => 'list',
    'list_type' => 'blog_posts',
];
$data['tt_content']['NEW_ListByCategory'] = [
    'pid' => 'NEW_blogCategoryPage',
    'CType' => 'list',
    'list_type' => 'blog_category',
];
$data['tt_content']['NEW_ListByTag'] = [
    'pid' => 'NEW_blogTagPage',
    'CType' => 'list',
    'list_type' => 'blog_tag',
];
$data['tt_content']['NEW_ListByAuthor'] = [
    'pid' => 'NEW_blogAuthorPage',
    'CType' => 'list',
    'list_type' => 'blog_authorposts',
];
$data['tt_content']['NEW_ListByDate'] = [
    'pid' => 'NEW_blogArchivePage',
    'CType' => 'list',
    'list_type' => 'blog_archive',
];
$data['tt_content']['NEW_firstBlogPostContent'] = [
    'pid' => 'NEW_firstBlogPostPage',
    'CType' => 'textmedia',
    'header' => 'First blog post',
    'bodytext' => 'This is your first blog post!',
];

// Categories
$data['sys_category']['NEW_blogCategoryRoot'] = [
    'pid' => 'NEW_blogFolder',
    'title' => 'Blog',
];
$data['sys_category']['NEW_blogCategoryTYPO3'] = [
    'pid' => 'NEW_blogFolder',
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
    'email' => 'info@typo3.com',
    'twitter' => 'typo3',
];

// Comment
$data['tx_blog_domain_model_comment']['NEW_blogComment'] = [
    'pid' => 'NEW_blogFolder',
    'status' => '10',
    'name' => 'TYPO3 Inc Team',
    'url' => 'https://typo3.com/',
    'email' => 'info@typo3.com',
    'comment' => 'Quisque vulputate, mauris eget tempus luctus, lorem ipsum interdum lorem, vitae maximus nulla est vel urna. In hac habitasse platea dictumst. Fusce lorem est, interdum vitae maximus sed, volutpat quis felis. Proin commodo velit sed rhoncus ornare. Ut a magna vitae est condimentum volutpat et ac ipsum. Nulla facilisi. Integer ut euismod felis. Aenean blandit eros neque.'
];

return $data;
