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

use Heise\Shariff\Backend;
use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
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
     */
    public function render() :array
    {
        $wizard = parent::initializeResultArray();
        // Smells fishy, but Lolli told me this is the way to do it
        if ($this->data['fieldName'] !== 'media') {
            return $wizard;
        }

        $urlParameters = [];
        $onClick = [];
        $onClick[] = 'this.blur();';
        $onClick[] = 'return !TBE_EDITOR.isFormChanged();';

        $foo = '';

        $control = [
            'iconIdentifier' => 'content-table',
            'title' => 'Blog o Matic',
            'linkAttributes' => [
                'onClick' => implode('', $onClick),
                'href' => BackendUtility::getModuleUrl('blogSocialWizard', $urlParameters),
            ],
        ];

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $link = $uriBuilder->buildUriFromRoute('ext-blog-social-wizard', ['pageUid' => $this->data['effectivePid']]);

        $wizard['html'] = 'My Markup Goes here';

        return $wizard;
    }
}