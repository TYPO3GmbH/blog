<?php

call_user_func(
    function () {
        $blogDocType = \T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST;

        // Add new page type:
        $GLOBALS['PAGES_TYPES'][$blogDocType] = [
            'type' => 'web',
            'allowedTables' => '*',
        ];

        // Provide icon for page tree, list view, ... :
        $icons = [
            'apps-pagetree-blog' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog.svg',
            'apps-pagetree-blog-category' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-category.svg',
            'apps-pagetree-blog-comment' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment.svg',
            'apps-pagetree-blog-comment-approved' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment-approved.svg',
            'apps-pagetree-blog-comment-blocked' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment-blocked.svg',
            'apps-pagetree-blog-comment-todo' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-comment-todo.svg',
            'apps-pagetree-blog-post' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-post.svg',
            'apps-pagetree-blog-tag' => 'EXT:blog/Resources/Public/Icons/apps-pagetree-blog-tag.svg',
        ];
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        foreach ($icons as $identifier => $path) {
            $iconRegistry->registerIcon(
                $identifier,
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                ['source' => $path]
            );
        }

        // Allow backend users to drag and drop the new page type:
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
            'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $blogDocType . ')'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'T3G.AgencyPack.Blog',
            'Posts',
            'Blog: List of posts'
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'T3G.AgencyPack.Blog',
            'Sidebar',
            'Blog: Sidebar'
        );
    }
);
