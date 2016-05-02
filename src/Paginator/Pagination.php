<?php
declare(strict_types=1);

namespace Staphp\Paginator;

use RuntimeException;
use Staphp\AbstractCollection;

class Pagination
{
    /**
     * @var AbstractCollection
     */
    private $items;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var int
     */
    private $currentPage = 1;

    /**
     * @var int
     */
    private $totalPages;

    /**
     * @var string|null
     */
    private $previousPageUrl;

    /**
     * @var string
     */
    private $currentPageUrl;

    /**
     * @var string|null
     */
    private $nextPageUrl;

    /**
     * @var string|null
     */
    private $baseUrl;

    public function __construct(AbstractCollection $items, int $itemsPerPage, string $baseUrl)
    {
        $this->items = $items;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->itemsPerPage = $itemsPerPage;
        $this->totalPages = (int) max(1, ceil(count($items) / $itemsPerPage));
        $this->currentPageUrl = $baseUrl;

        if ($this->totalPages > 1) {
            $this->nextPageUrl = $this->baseUrl . '/page-2/';
        }
    }

    public function advance() : bool
    {
        if ($this->currentPage === $this->totalPages) {
            return false;
        }

        ++$this->currentPage;

        if (2 === $this->currentPage) {
            $this->previousPageUrl = $this->baseUrl . '/';
        } else {
            $this->previousPageUrl = $this->baseUrl . '/page-' . ($this->currentPage - 1) . '/';
        }

        $this->currentPageUrl = $this->nextPageUrl;

        if ($this->currentPage < $this->totalPages) {
            $this->nextPageUrl = $this->baseUrl . '/page-' . ($this->currentPage + 1) . '/';
        } else {
            $this->nextPageUrl = null;
        }

        return true;
    }

    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function getCurrentPage() : int
    {
        return $this->currentPage;
    }

    public function getTotalPages() : int
    {
        return $this->totalPages;
    }

    public function hasPreviousPageUrl() : bool
    {
        return null !== $this->previousPageUrl;
    }

    public function getPreviousPageUrl() : string
    {
        if (null === $this->previousPageUrl) {
            throw new RuntimeException('Pagination has no previous page URL');
        }

        return $this->previousPageUrl;
    }

    public function getCurrentPageUrl() : string
    {
        return $this->currentPageUrl;
    }

    public function hasNextPageUrl() : bool
    {
        return null !== $this->nextPageUrl;
    }

    public function getNextPageUrl() : string
    {
        if (null === $this->nextPageUrl) {
            throw new RuntimeException('Pagination has no next page URL');
        }

        return $this->nextPageUrl;
    }

    public function getItems() : AbstractCollection
    {
        return $this->items->splice(($this->currentPage - 1) * $this->itemsPerPage, $this->itemsPerPage);
    }
}
