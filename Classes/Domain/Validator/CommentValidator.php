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
        }
    }
}
