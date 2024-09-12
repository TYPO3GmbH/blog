<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Filter;

use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Interface for post filters used in the listPostsByFilterAction.
 */
interface PostFilter
{
    /**
     * The name of this filter, used for rendering the corresponding Fluid partial.
     */
    public function getName(): string;

    /**
     * The title of the filter result, used in MetaTagService.
     */
    public function getTitle(): string;

    /**
     * A description of the filter result, used in MetaTagService.
     */
    public function getDescription(): string;

    /**
     * Apply current filter values in given Posts query.
     *
     * @return array<ComparisonInterface>
     */
    public function getConstraints(QueryInterface $query): array;
}
