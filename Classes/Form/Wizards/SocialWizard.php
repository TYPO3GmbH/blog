<?php

namespace T3G\AgencyPack\Blog\Form\Wizards;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class SocialWizard
 *
 * @package T3G\AgencyPack\Blog\Form\Wizards
 */
class SocialWizard extends AbstractNode
{
    /**
     * @return array
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public function render() :array
    {
        $wizard = parent::initializeResultArray();
        // Smells fishy, but Lolli told me this is the way to do it
        //
        if ($this->data['fieldName'] !== 'media') {
            return $wizard;
        }

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $link = $uriBuilder->buildUriFromRoute('ext-blog-social-wizard', ['id' => $this->data['effectivePid']]);

        $wizard['html'] = '<span class="btn btn-default t3js-blog-social-image-wizard" data-wizard-url="' . $link->getPath() . '?' . $link->getQuery(). '">Open Social Image Wizard</span>';
        $wizard['requireJsModules']['SocialImageWizard'] = 'TYPO3/CMS/Blog/SocialImageWizard';

        return $wizard;
    }
}