<?php

/**
 * Definitions for routes provided by EXT:blog
 * Contains all AJAX-based routes for entry points
 */
return [
    // Save images
    'ext-blog-social-wizard-save-image' => [
        'path' => '/ext/blog/social-wizard/save-image',
        'target' => \T3G\AgencyPack\Blog\Form\Wizards\SocialImageWizardController::class . '::saveImageAction'
    ]
];
