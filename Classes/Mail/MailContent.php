<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Mail;

use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $settings = [];
        $frontendController = $this->getTypoScriptFrontendController();
        if ($frontendController instanceof TypoScriptFrontendController) {
            $settings = $frontendController->tmpl->setup['plugin.']['tx_blog.'] ?? [];
            $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
            $settings = $typoScriptService->convertTypoScriptArrayToPlainArray($settings);
        }

        $view->setLayoutRootPaths($settings['view']['emails']['layoutRootPaths'] ?? []);
        $view->setPartialRootPaths($settings['view']['emails']['partialRootPaths'] ?? []);
        $view->setTemplateRootPaths($settings['view']['emails']['templateRootPaths'] ?? []);
        $view->setTemplate($template);

        return $view;
    }

    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
