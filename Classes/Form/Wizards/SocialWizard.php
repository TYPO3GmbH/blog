<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Form\Wizards;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
        if ($this->data['fieldName'] !== 'media' ||
            (int)$this->data['recordTypeValue'] !== (int)\T3G\AgencyPack\Blog\Constants::DOKTYPE_BLOG_POST) {
            return $wizard;
        }

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $link = $uriBuilder->buildUriFromRoute('ext-blog-social-wizard', ['id' => $this->data['effectivePid']]);

        $wizard['html'] = '<span class="btn btn-default t3js-blog-social-image-wizard" data-wizard-url="' . $link->getPath() . '?' . $link->getQuery() . '">Open Social Image Wizard</span>';
        $wizard['requireJsModules']['SocialImageWizard'] = 'TYPO3/CMS/Blog/SocialImageWizard';

        return $wizard;
    }
}
