<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Validator;

use T3G\AgencyPack\Blog\Domain\Model\Comment;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class GoogleCaptchaValidator extends AbstractValidator
{
    protected $acceptsEmptyValues = false;

    public function isValid($value): void
    {
        $action = 'form';
        $controller = 'Comment';
        $settings = [];
        $frontendController = $this->getTypoScriptFrontendController();
        if ($frontendController instanceof TypoScriptFrontendController) {
            $settings = $frontendController->tmpl->setup['plugin.']['tx_blog.']['settings.'] ?? [];
            $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
            $settings = $typoScriptService->convertTypoScriptArrayToPlainArray($settings);
        }
        $requestData = GeneralUtility::_GPmerged('tx_blog_commentform');

        if (
            // this validator is called multiple times, if the first success,
            // the global variable is set, else validate the re-captcha
            empty($GLOBALS['google_recaptcha'])
            // check if we create a new comment, else we don't need a validation
            && (!empty($requestData['action']) && $requestData['action'] === $action)
            && (!empty($requestData['controller']) && $requestData['controller'] === $controller)
            // check if google re-captcha is active, else we don't need a validation
            && (int) $settings['comments']['google_recaptcha']['_typoScriptNodeValue'] === 1
        ) {
            $additionalOptions = [
                'headers' => ['Content-type' => 'application/x-www-form-urlencoded'],
                'query' => [
                    'secret' => $settings['comments']['google_recaptcha']['secret_key'],
                    'response' => GeneralUtility::_GP('g-recaptcha-response'),
                    'remoteip' => GeneralUtility::getIndpEnv('REMOTE_ADDR')
                ]
            ];
            $response = GeneralUtility::makeInstance(RequestFactory::class)
                ->request('https://www.google.com/recaptcha/api/siteverify', 'POST', $additionalOptions);
            if ($response->getStatusCode() === 200) {
                $result = json_decode($response->getBody()->getContents());
                if (!$result->success) {
                    $this->addError('The re-captcha failed', 1501341100);
                } else {
                    $GLOBALS['google_recaptcha'] = true;
                }
            }
        }
    }

    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
