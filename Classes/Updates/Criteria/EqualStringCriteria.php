<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates\Criteria;

use TYPO3\CMS\Core\Database\Connection;

class EqualStringCriteria extends AbstractCriteria implements CriteriaInterface
{
    protected string $value;

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->queryBuilder->expr()->eq(
            $this->getField(),
            $this->queryBuilder->createNamedParameter(
                $this->getValue(),
                Connection::PARAM_STR
            )
        );
    }
}
