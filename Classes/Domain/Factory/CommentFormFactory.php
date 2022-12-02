<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Factory;

use T3G\AgencyPack\Blog\Domain\Finisher\CommentFormFinisher;
use T3G\AgencyPack\Blog\Domain\Validator\GoogleCaptchaValidator;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;
use TYPO3\CMS\Extbase\Validation\Validator\StringLengthValidator;
use TYPO3\CMS\Extbase\Validation\Validator\UrlValidator;
use TYPO3\CMS\Form\Domain\Configuration\ConfigurationService;
use TYPO3\CMS\Form\Domain\Factory\AbstractFormFactory;
use TYPO3\CMS\Form\Domain\Finishers\RedirectFinisher;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class CommentFormFactory extends AbstractFormFactory
{
    protected TypoScriptService $typoScriptService;

    public function __construct(TypoScriptService $typoScriptService)
    {
        $this->typoScriptService = $typoScriptService;
    }
    /**
     * Build a FormDefinition.
     * This example build a FormDefinition manually,
     * so $configuration and $prototypeName are unused.
     *
     * @param array $configuration
     * @param string $prototypeName
     * @return FormDefinition
     */
    public function build(array $configuration, string $prototypeName = null): FormDefinition
    {
        $prototypeName = 'standard';
        $formConfigurationService = GeneralUtility::makeInstance(ConfigurationService::class);
        $prototypeConfiguration = $formConfigurationService->getPrototypeConfiguration($prototypeName);
        $prototypeConfiguration['formElementsDefinition']['BlogGoogleCaptcha'] = $prototypeConfiguration['formElementsDefinition']['BlogGoogleCaptcha'] ?? [];
        ArrayUtility::mergeRecursiveWithOverrule(
            $prototypeConfiguration['formElementsDefinition']['BlogGoogleCaptcha'],
            [
                'implementationClassName' => 'TYPO3\CMS\Form\Domain\Model\FormElements\GenericFormElement'
            ]
        );

        $blogSettings = [];
        $frontendController = $this->getTypoScriptFrontendController();
        if ($frontendController instanceof TypoScriptFrontendController) {
            $settings = $frontendController->tmpl->setup['plugin.']['tx_blog.']['settings.'] ?? [];
            $blogSettings = $this->typoScriptService->convertTypoScriptArrayToPlainArray($settings);
        }
        $captcha = [];
        $captcha['enable'] = (bool) ($blogSettings['comments']['google_recaptcha']['_typoScriptNodeValue'] ?? false);
        $captcha['sitekey'] = (string) trim($blogSettings['comments']['google_recaptcha']['website_key'] ?? '');
        $captcha['secret'] = (string) trim($blogSettings['comments']['google_recaptcha']['secret_key'] ?? '');

        $form = GeneralUtility::makeInstance(FormDefinition::class, 'postcomment', $prototypeConfiguration);
        $form->setRenderingOption('controllerAction', 'form');
        $form->setRenderingOption('submitButtonLabel', LocalizationUtility::translate('form.comment.submit', 'blog'));
        $renderingOptions = $form->getRenderingOptions();
        $renderingOptions['partialRootPaths'][-1634043971] = 'EXT:blog/Resources/Private/Partials/Form/';
        $form->setRenderingOption('partialRootPaths', $renderingOptions['partialRootPaths']);

        $page = $form->createPage('commentform');

        // Form
        $nameField = $page->createElement('name', 'Text');
        $nameField->setLabel(LocalizationUtility::translate('form.comment.name', 'blog'));
        $nameField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));

        $emailField = $page->createElement('email', 'Text');
        $emailField->setLabel(LocalizationUtility::translate('form.comment.email', 'blog'));
        $emailField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
        $emailField->addValidator(GeneralUtility::makeInstance(EmailAddressValidator::class));

        if ((bool) $blogSettings['comments']['features']['urls']) {
            $urlField = $page->createElement('url', 'Text');
            $urlField->setLabel(LocalizationUtility::translate('form.comment.url', 'blog'));
            $urlField->addValidator(GeneralUtility::makeInstance(UrlValidator::class));
        }

        $commentField = $page->createElement('comment', 'Textarea');
        $commentField->setLabel(LocalizationUtility::translate('form.comment.comment', 'blog'));
        $commentField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
        $stringLengthValidator = GeneralUtility::makeInstance(StringLengthValidator::class);
        $stringLengthValidator->setOptions(['minimum' => 5]);
        $commentField->addValidator($stringLengthValidator);

        $explanationText = $page->createElement('explanation', 'StaticText');
        $explanationText->setProperty('text', LocalizationUtility::translate('label.required.field', 'blog') . ' ' . LocalizationUtility::translate('label.required.field.explanation', 'blog'));

        if ($captcha['enable'] && $captcha['sitekey'] && $captcha['secret']) {
            $captchaField = $page->createElement('captcha', 'BlogGoogleCaptcha');
            $captchaField->setProperty('sitekey', $captcha['sitekey']);
            $captchaField->addValidator(GeneralUtility::makeInstance(GoogleCaptchaValidator::class));
        }

        // Finisher
        $commentFinisher = GeneralUtility::makeInstance(CommentFormFinisher::class);
        if (method_exists($commentFinisher, 'setFinisherIdentifier')) {
            $commentFinisher->setFinisherIdentifier(CommentFormFinisher::class);
        }
        $form->addFinisher($commentFinisher);

        $redirectFinisher = GeneralUtility::makeInstance(RedirectFinisher::class);
        if (method_exists($redirectFinisher, 'setFinisherIdentifier')) {
            $redirectFinisher->setFinisherIdentifier(RedirectFinisher::class);
        }
        $redirectFinisher->setOption('pageUid', (string)$this->getTypoScriptFrontendController()->id);
        $form->addFinisher($redirectFinisher);

        $this->triggerFormBuildingFinished($form);
        return $form;
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
