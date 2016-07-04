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
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validator for comments
 */
class CommentValidator extends AbstractValidator
{
    /**
     * Checks if the given comment is valid
     *
     * @param mixed $value The comment model
     * @return void
     */
    public function isValid($value)
    {
        if ($value instanceof Comment) {
            if (trim($value->getName()) === '') {
                $this->addError('the name is required', 1467650564);
            }
            if (trim($value->getEmail()) === '') {
                $this->addError('the email is required', 1467650565);
            }
            if (filter_var($value->getEmail(), FILTER_VALIDATE_EMAIL) !== $value->getEmail()) {
                $this->addError('the email address has an invalid format', 1467650566);
            }
            if (trim($value->getComment()) === '') {
                $this->addError('the comment is required', 1467650567);
            }
        }
    }
}
