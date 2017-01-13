<?php

/** @var array $data */
$data = [];

// Pages
$data['pages']['NEW_blogRoot'] = [
    'pid' => 0,
    'hidden' => 1,
    'title' => 'Blog',
    'doktype' => 1,
    'is_siteroot' => 1,
    'TSconfig' => 'TCEFORM.pages.tags.PAGE_TSCONFIG_ID = NEW_blogFolder
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
$data['pages']['NEW_blogArchivePage'] = [
    'pid' => '-NEW_blogTagPage',
    'hidden' => 0,
    'title' => 'Archive',
    'doktype' => 1,
];
$data['pages']['NEW_firstBlogPostPage'] = [
    'pid' => '-NEW_blogArchivePage',
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
    'include_static_file' => 'EXT:fluid_styled_content/Configuration/TypoScript/Static/,EXT:blog/Configuration/TypoScript/Static/',
    'constants' => 'plugin.tx_blog.settings.blogUid = NEW_blogRoot
plugin.tx_blog.settings.categoryUid = NEW_blogCategoryPage
plugin.tx_blog.settings.tagUid = NEW_blogTagPage
plugin.tx_blog.settings.archiveUid = NEW_blogArchivePage
plugin.tx_blog.persistence.storagePid = NEW_blogFolder',
    'config' => 'plugin.tx_blog.settings.sharing.enabled = 0
page = PAGE
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

return $data;
