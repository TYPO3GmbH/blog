<?php

namespace T3G\AgencyPack\Blog\Domain\Validator;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use T3G\AgencyPack\Blog\Domain\Model\Comment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validator for comments.
 */
class CommentValidator extends AbstractValidator
{
    /**
     * Checks if the given comment is valid.
     *
     * @param mixed $value The comment model
     *
     * @throws \InvalidArgumentException
     */
    public function isValid($value)
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
            if ((int)$settings['comments']['google_recaptcha']['_typoScriptNodeValue'] === 1) {
                // this validator is called multiple times, if the first success,
                // the global variable is set, else validate the re-captcha
                if (empty($GLOBALS['google_recaptcha'])) {
                    $post_data = http_build_query([
                        'secret' => $settings['comments']['google_recaptcha']['secret_key'],
                        'response' => GeneralUtility::_GP('g-recaptcha-response'),
                        'remoteip' => $_SERVER['REMOTE_ADDR']
                    ]);
                    $opts = [
                        'http' => [
                            'method'  => 'POST',
                            'header'  => 'Content-type: application/x-www-form-urlencoded',
                            'content' => $post_data
                        ]
                    ];
                    $context  = stream_context_create($opts);
                    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
                    $result = json_decode($response);
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
