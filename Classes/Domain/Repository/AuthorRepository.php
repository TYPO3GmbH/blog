<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class AuthorRepository.
 */
class AuthorRepository extends Repository
{
    /**
     * Initializes the repository.
     *
     * @throws \InvalidArgumentException
     */
    public function initializeObject(): void
    {
        $this->defaultOrderings = [
            'name' => QueryInterface::ORDER_ASCENDING,
        ];
    }
}
