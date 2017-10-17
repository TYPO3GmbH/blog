<?php

/**
 * Definitions for routes provided by EXT:blog
 * Contains all AJAX-based routes for entry points
 */
return [
    // Save images
    'ext-blog-social-wizard-save-image' => [
        'path' => '/ext/blog/social-wizard/save-image',
        'target' => \T3G\AgencyPack\Blog\Form\Wizards\SocialImageAjaxController::class . '::saveImageAction'
    ],
    // get existing relation
    'ext-blog-social-wizard-get-relations' => [
        'path' => '/ext/blog/social-wizard/get-relations',
        'target' => \T3G\AgencyPack\Blog\Form\Wizards\SocialImageAjaxController::class . '::existingRelationsAction'
    ],
    // replace existing relation
    'ext-blog-social-wizard-replace-relation' => [
        'path' => '/ext/blog/social-wizard/replace-relation',
        'target' => \T3G\AgencyPack\Blog\Form\Wizards\SocialImageAjaxController::class . '::replaceRelationAction'
    ],
    // insert after existing relation
    'ext-blog-social-wizard-insert-after-relation' => [
        'path' => '/ext/blog/social-wizard/insert-after-relation',
        'target' => \T3G\AgencyPack\Blog\Form\Wizards\SocialImageAjaxController::class . '::insertAfterRelationAction'
    ],
];
