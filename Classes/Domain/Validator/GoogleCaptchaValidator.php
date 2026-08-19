<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Validator;

use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\ExtbaseRequestParameters;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class GoogleCaptchaValidator extends AbstractValidator
{
    protected $acceptsEmptyValues = false;

    public function isValid(mixed $value): void
    {
        $action = 'form';
        $controller = 'Comment';
        $settings = GeneralUtility::makeInstance(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');
        $request = $this->request ?? $GLOBALS['TYPO3_REQUEST'];
        $bodyData = $request->getParsedBody();
        $extbaseParameters = $request->getAttribute('extbase');

        if (
            // this validator is called multiple times, if the first success,
            // the global variable is set, else validate the re-captcha
            ($GLOBALS['google_recaptcha'] ?? null) === null
            // check if we create a new comment, else we don't need a validation
            && $extbaseParameters instanceof ExtbaseRequestParameters
            && $extbaseParameters->getControllerName() === $controller
            && $extbaseParameters->getControllerActionName() === $action
            // check if google re-captcha is active, else we don't need a validation
            && (int) ($settings['comments']['google_recaptcha']['enable'] ?? 0) === 1
        ) {
            /** @var ?NormalizedParams $normalizedParams */
            $normalizedParams = $request->getAttribute('normalizedParams');
            $additionalOptions = [
                'headers' => ['Content-type' => 'application/x-www-form-urlencoded'],
                'query' => [
                    'secret' => $settings['comments']['google_recaptcha']['secret_key'],
                    'response' => $bodyData['g-recaptcha-response'] ?? '',
                    'remoteip' => $normalizedParams?->getRemoteAddress()
                ]
            ];
            $response = GeneralUtility::makeInstance(RequestFactory::class)
                ->request('https://www.google.com/recaptcha/api/siteverify', 'POST', $additionalOptions);
            if ($response->getStatusCode() !== 200) {
                $this->addError('The re-captcha could not be verified', 1787128468);
                return;
            }
            $result = json_decode((string)$response->getBody()->getContents(), true);
            if (!is_array($result) || ($result['success'] ?? false) !== true) {
                $this->addError('The re-captcha failed', 1501341100);
                return;
            }
            $GLOBALS['google_recaptcha'] = true;
        }
    }
}
