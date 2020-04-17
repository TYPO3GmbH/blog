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
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

class MailContent
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
