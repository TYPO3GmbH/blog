<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Updates\Criteria;

class IsNullCriteria extends AbstractCriteria implements CriteriaInterface
{
    public function __toString(): string
    {
        return $this->queryBuilder->expr()->isNull($this->getField());
    }
}
