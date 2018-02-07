<?php

namespace T3G\AgencyPack\Blog\Messaging;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class MailMessage
 * @package T3G\AgencyPack\Blog\Messaging
 */
class MailMessage
{

    /**
     * @param string $template
     * @param array $arguments
     *
     * @return string
     * @throws \RuntimeException
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \InvalidArgumentException
     */
    public function render(string $template, array $arguments) : string
    {
        $view = $this->getFluidTemplateObject($template);
        $view->assignMultiple($arguments);
        return $view->render();
    }


    /**
     * returns a new standalone view, shorthand function.
     *
     * @param string $template
     *
     * @return StandaloneView
     * @throws \RuntimeException
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \InvalidArgumentException
     */
    protected function getFluidTemplateObject($template) : StandaloneView
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $settings = $objectManager
            ->get(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'blog');
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setLayoutRootPaths($settings['view']['emails']['layoutRootPaths']);
        $view->setPartialRootPaths($settings['view']['emails']['partialRootPaths']);
        $view->setTemplateRootPaths($settings['view']['emails']['templateRootPaths']);
        $view->setTemplate($template);
        $view->getRequest()->setControllerExtensionName('blog');

        return $view;
    }
}
