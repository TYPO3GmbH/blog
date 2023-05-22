<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Pagination;

use TYPO3\CMS\Core\Pagination\PaginationInterface;
use TYPO3\CMS\Core\Pagination\PaginatorInterface;

final class BlogPagination implements PaginationInterface
{
    protected int $maximumNumberOfLinks = 10;
    protected int $displayRangeStart = 0;
    protected int $displayRangeEnd = 0;
    protected PaginatorInterface $paginator;

    public function __construct(PaginatorInterface $paginator, int $maximumNumberOfLinks = 10)
    {
        $this->paginator = $paginator;
        $this->maximumNumberOfLinks = $maximumNumberOfLinks > 0 ? $maximumNumberOfLinks : 1;
        $this->displayRangeStart = $this->getFirstPageNumber();
        $this->displayRangeEnd = $this->getLastPageNumber();

        $this->generateDisplayRange();
    }

    protected function generateDisplayRange(): void
    {
        $currentPageNumber = $this->getCurrentPageNumber();
        $maximumNumberOfLinks = $this->getMaximumNumberOfLinks();
        $delta = (int) floor($maximumNumberOfLinks / 2);
        if ($this->getNumberOfPages() > $maximumNumberOfLinks) {
            $this->displayRangeStart = $currentPageNumber - $delta;
            $this->displayRangeEnd = $this->displayRangeStart + $maximumNumberOfLinks - 1;
            while ($this->displayRangeStart < $this->getFirstPageNumber()) {
                $this->displayRangeStart++;
                $this->displayRangeEnd++;
            }
            while ($this->displayRangeEnd > $this->getLastPageNumber()) {
                $this->displayRangeStart--;
                $this->displayRangeEnd--;
            }
        }
    }

    public function getPreviousPageNumber(): ?int
    {
        $previousPage = $this->paginator->getCurrentPageNumber() - 1;

        if ($previousPage > $this->paginator->getNumberOfPages()) {
            return null;
        }

        return $previousPage >= $this->getFirstPageNumber()
            ? $previousPage
            : null;
    }

    public function getCurrentPageNumber(): int
    {
        return $this->paginator->getCurrentPageNumber();
    }

    public function getNextPageNumber(): ?int
    {
        $nextPage = $this->paginator->getCurrentPageNumber() + 1;

        return $nextPage <= $this->paginator->getNumberOfPages()
            ? $nextPage
            : null;
    }

    public function getFirstPageNumber(): int
    {
        return 1;
    }

    public function getLastPageNumber(): int
    {
        return $this->paginator->getNumberOfPages();
    }

    public function getStartRecordNumber(): int
    {
        if ($this->paginator->getCurrentPageNumber() > $this->paginator->getNumberOfPages()) {
            return 0;
        }

        return $this->paginator->getKeyOfFirstPaginatedItem() + 1;
    }

    public function getEndRecordNumber(): int
    {
        if ($this->paginator->getCurrentPageNumber() > $this->paginator->getNumberOfPages()) {
            return 0;
        }

        return $this->paginator->getKeyOfLastPaginatedItem() + 1;
    }

    public function getNumberOfPages(): int
    {
        return $this->paginator->getNumberOfPages();
    }

    /**
     * @return int[]
     */
    public function getAllPageNumbers(): array
    {
        return range($this->getFirstPageNumber(), $this->getLastPageNumber());
    }

    public function getDisplayRangeStart(): int
    {
        return $this->displayRangeStart;
    }

    public function getDisplayRangeEnd(): int
    {
        return $this->displayRangeEnd;
    }

    /**
     * @return int[]
     */
    public function getDisplayPageNumbers(): array
    {
        return range($this->getDisplayRangeStart(), $this->getDisplayRangeEnd());
    }

    public function hasLessPages(): bool
    {
        return $this->getDisplayRangeStart() > $this->getFirstPageNumber();
    }

    public function hasMorePages(): bool
    {
        return $this->getDisplayRangeEnd() < $this->getLastPageNumber();
    }

    public function getMaximumNumberOfLinks(): int
    {
        return $this->maximumNumberOfLinks;
    }

    public function getPaginator(): PaginatorInterface
    {
        return $this->paginator;
    }

    public function getPaginatedItems(): iterable
    {
        return $this->paginator->getPaginatedItems();
    }
}
