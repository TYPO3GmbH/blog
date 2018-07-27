<?php

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'ext-blog-social-wizard' => [
        'path' => 'ext/blog/social-image-wizard',
        'target' => \T3G\AgencyPack\Blog\Form\Wizards\SocialImageWizardController::class . '::indexAction'
    ]
];
