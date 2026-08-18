<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\ViewHelpers\Data;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Constants;
use TYPO3\CMS\Core\Schema\Capability\FieldCapability;
use TYPO3\CMS\Core\Schema\Capability\LanguageAwareSchemaCapability;
use TYPO3\CMS\Core\Schema\Capability\SystemInternalFieldCapability;
use TYPO3\CMS\Core\Schema\Capability\TcaSchemaCapability;
use TYPO3\CMS\Core\Schema\TcaSchemaFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ContentListOptionsViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('as', 'string', 'Name of variable to create.');
        // @todo rename to type
        $this->registerArgument('listType', 'string', 'Plugin Type to Render', true);
    }

    public function render(): string
    {
        if (null === $this->renderingContext) {
            throw new \RuntimeException('CacheViewHelper requires an existing rendering context.', 1781701009);
        }
        $arguments = $this->arguments;
        $settings = GeneralUtility::makeInstance(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');
        $listTypeConfiguration = $settings['contentListOptions'][$arguments['listType']] ?? [];
        $request = $this->renderingContext->hasAttribute(ServerRequestInterface::class)
            ? $this->renderingContext->getAttribute(ServerRequestInterface::class)
            : null;
        $data = array_merge(
            $this->getSystemFieldDefaults((int)($request?->getAttribute('language')?->getLanguageId() ?? 0)),
            $listTypeConfiguration,
            [
                'uid' => Constants::LISTTYPE_TO_FAKE_UID_MAPPING[$arguments['listType']] ?? 0,
                'pid' => (int)($request?->getAttribute('frontend.page.information')?->getId() ?? 0),
                'CType' => $arguments['listType'] ?? '',
                'layout' => $listTypeConfiguration['layout'] ?? '0',
                'frame_class' => $listTypeConfiguration['frame_class'] ?? 'default'
            ]
        );

        $arguments['as'] = $arguments['as'] ?? 'contentObjectData';
        $variableProvider = $this->renderingContext->getVariableProvider();
        $variableProvider->remove($arguments['as']);
        $variableProvider->add($arguments['as'], $data);

        return '';
    }

    /**
     * RecordFactory rejects a row missing a field tt_content declares a system
     * capability for. Defaults are read off the schema to cover later additions.
     *
     * @return array<string, int|string>
     */
    protected function getSystemFieldDefaults(int $languageId): array
    {
        $schema = GeneralUtility::makeInstance(TcaSchemaFactory::class)->get('tt_content');
        $defaults = [];

        if ($schema->isLanguageAware()) {
            /** @var LanguageAwareSchemaCapability $languageCapability */
            $languageCapability = $schema->getCapability(TcaSchemaCapability::Language);
            $defaults[$languageCapability->getLanguageField()->getName()] = $languageId;
            $defaults[$languageCapability->getTranslationOriginPointerField()->getName()] = 0;
            $translationSourceField = $languageCapability->getTranslationSourceField();
            if ($translationSourceField !== null) {
                $defaults[$translationSourceField->getName()] = 0;
            }
        }

        if ($schema->isWorkspaceAware()) {
            $defaults['t3ver_wsid'] = 0;
            $defaults['t3ver_oid'] = 0;
            $defaults['t3ver_state'] = 0;
            $defaults['t3ver_stage'] = 0;
        }

        foreach (TcaSchemaCapability::getSystemCapabilities() as $capability) {
            if (!$schema->hasCapability($capability)) {
                continue;
            }
            $capabilityInstance = $schema->getCapability($capability);
            if (!$capabilityInstance instanceof FieldCapability
                && !$capabilityInstance instanceof SystemInternalFieldCapability
            ) {
                continue;
            }
            $fieldName = $capabilityInstance->getFieldName();
            // fe_group and the description are read as strings, the rest as int.
            $defaults[$fieldName] = match ($capability) {
                TcaSchemaCapability::InternalDescription, TcaSchemaCapability::RestrictionUserGroup => '',
                default => 0,
            };
        }

        return $defaults;
    }
}
