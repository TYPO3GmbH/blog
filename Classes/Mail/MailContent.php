<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Mail;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class MailContent
{
    public function __construct(
        protected readonly ConfigurationManagerInterface $configurationManager,
        protected readonly ViewFactoryInterface $viewFactory
    ) {
    }

    public function render(string $template, array $arguments): string
    {
        $view = $this->getTemplateObject(new ServerRequest());
        $view->assignMultiple($arguments);

        return $view->render($template);
    }

    protected function getTemplateObject(ServerRequestInterface $request): ViewInterface
    {
        $settings = $this->configurationManager
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'blog');

        return $this->viewFactory->create(new ViewFactoryData(
            templateRootPaths: $settings['view']['emails']['templateRootPaths'] ?? [],
            partialRootPaths: $settings['view']['emails']['partialRootPaths'] ?? [],
            layoutRootPaths: $settings['view']['emails']['layoutRootPaths'] ?? [],
            request: $request,
        ));
    }
}
