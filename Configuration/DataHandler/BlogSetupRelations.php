<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$data = [];

// Relations
$data['pages']['NEW_firstBlogPostPage']['tags'] = 'NEW_blogTagTYPO3';
$data['pages']['NEW_firstBlogPostPage']['categories'] = 'NEW_blogCategoryTYPO3';
$data['pages']['NEW_firstBlogPostPage']['comments'] = 'NEW_blogComment';
$data['pages']['NEW_firstBlogPostPage']['authors'] = 'NEW_blogAuthor';
$data['tx_blog_domain_model_author']['NEW_blogAuthor']['posts'] = 'NEW_firstBlogPostPage';

return $data;
