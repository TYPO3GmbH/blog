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

class InCriteria extends AbstractCriteria implements CriteriaInterface
{
    protected array $values;

    public function setValues(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function __toString(): string
    {
        return $this->queryBuilder->expr()->in(
            $this->getField(),
            $this->queryBuilder->createNamedParameter(
                $this->getValues(),
                Connection::PARAM_STR_ARRAY
            )
        );
    }
}
