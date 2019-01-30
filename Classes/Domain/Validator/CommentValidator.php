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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class CommentValidator extends AbstractValidator
{
    /**
     * Checks if the given comment is valid.
     *
     * @param mixed $value The comment model
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     */
    public function isValid($value): void
    {
        if ($value instanceof Comment) {
            if (trim($value->getHp()) !== '') {
                $this->addError('It looks like you are a bot!', 1484142303);
            }
            if (trim($value->getName()) === '') {
                $this->addError('The name is required', 1467650564);
            }
            if (trim($value->getEmail()) === '') {
                $this->addError('The email is required', 1467650565);
            }
            if (!GeneralUtility::validEmail($value->getEmail())) {
                $this->addError('The email address has an invalid format', 1467650566);
            }
            if (trim($value->getComment()) === '') {
                $this->addError('The comment is required', 1467650567);
            }
            if (trim($value->getUrl()) !== '' && !GeneralUtility::isValidUrl(trim($value->getUrl()))) {
                $this->addError('The url has an invalid format', 1467650568);
            }

            $settings = GeneralUtility::makeInstance(ObjectManager::class)
                ->get(ConfigurationManagerInterface::class)
                ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');
            $requestData = GeneralUtility::_GPmerged('tx_blog_commentform');
            if (
                // this validator is called multiple times, if the first success,
                // the global variable is set, else validate the re-captcha
                empty($GLOBALS['google_recaptcha'])
                // check if we create a new comment, else we don't need a validation
                && (!empty($requestData['action']) && $requestData['action'] === 'addComment')
                && (!empty($requestData['controller']) && $requestData['controller'] === 'Comment')
                // check if google re-captcha is active, else we don't need a validation
                && (int)$settings['comments']['google_recaptcha']['_typoScriptNodeValue'] === 1
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
    }
}
