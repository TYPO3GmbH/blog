<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Data;

use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

class ContentListOptionsViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    public function initializeArguments(): void
    {
        $this->registerArgument('as', 'string', 'Name of variable to create.');
        $this->registerArgument('listType', 'string', 'Plugin Type to Render', true);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        $settings = GeneralUtility::makeInstance(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'blog');
        $listTypeConfiguration = $settings['settings']['contentListOptions'][$arguments['listType']] ?? [];
        $data = array_merge(
            $listTypeConfiguration,
            [
                'uid' => Constants::LISTTYPE_TO_FAKE_UID_MAPPING[$arguments['listType']] ?? 0,
                'list_type' => $arguments['listType'] ?? '',
                'CType' => 'list',
                'layout' => $listTypeConfiguration['layout'] ?? '0',
                'frame_class' => $listTypeConfiguration['frame_class'] ?? 'default'
            ]
        );

        $arguments['as'] = $arguments['as'] ?? 'contentObjectData';
        $variableProvider = $renderingContext->getVariableProvider();
        $variableProvider->remove($arguments['as']);
        $variableProvider->add($arguments['as'], $data);

        return '';
    }
}
