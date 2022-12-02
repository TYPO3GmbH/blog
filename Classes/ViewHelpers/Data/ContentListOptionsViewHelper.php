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
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

class ContentListOptionsViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        $this->registerArgument('as', 'string', 'Name of variable to create.');
        $this->registerArgument('listType', 'string', 'Plugin Type to Render', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $settings = [];
        $frontendController = self::getTypoScriptFrontendController();
        if ($frontendController instanceof TypoScriptFrontendController) {
            $settings = $frontendController->tmpl->setup['plugin.']['tx_blog.'] ?? [];
            $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
            $settings = $typoScriptService->convertTypoScriptArrayToPlainArray($settings);
        }
        $listTypeConfiguration = $settings['settings']['contentListOptions'][$arguments['listType']] ?? [];
        $data = array_merge(
            $listTypeConfiguration,
            [
                'uid' => Constants::LISTTYPE_TO_FAKE_UID_MAPPING[$arguments['listType']] ?? 0,
                'list_type' => (string) $arguments['listType'] ?? '',
                'CType' => 'list',
                'layout' => $listTypeConfiguration['layout'] ?? '0',
                'frame_class' => $listTypeConfiguration['frame_class'] ?? 'default'
            ]
        );

        $arguments['as'] = $arguments['as'] ?? 'contentObjectData';
        $variableProvider = $renderingContext->getVariableProvider();
        $variableProvider->remove($arguments['as']);
        $variableProvider->add($arguments['as'], $data);
    }

    protected static function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
