<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Mail;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class MailContent
{
    public function render(string $template, array $arguments): string
    {
        $view = $this->getFluidTemplateObject($template);
        $view->assignMultiple($arguments);
        return $view->render();
    }

    protected function getFluidTemplateObject(string $template): StandaloneView
    {
        $settings = GeneralUtility::makeInstance(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setLayoutRootPaths($settings['view']['emails']['layoutRootPaths']);
        $view->setPartialRootPaths($settings['view']['emails']['partialRootPaths']);
        $view->setTemplateRootPaths($settings['view']['emails']['templateRootPaths']);
        $view->setTemplate($template);
        $view->getRequest()->setControllerExtensionName('blog');

        return $view;
    }
}
