<?php
declare(strict_types=1);

namespace Staphp\Paginator;

use RuntimeException;
use Staphp\AbstractCollection;

class Paginator
{
    /**
     * @var string|null
     */
    private $baseUrl;

    /**
     * @var Pagination|null
     */
    private $pagination;

    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function hasPagination() : bool
    {
        return null !== $this->pagination;
    }

    public function resetPagination()
    {
        $this->pagination = null;
    }

    public function getPagination() : Pagination
    {
        if (null === $this->pagination) {
            throw new RuntimeException('Paginator has no pagination');
        }

        return $this->pagination;
    }

    public function __invoke(AbstractCollection $items, array $options = []) : Pagination
    {
        if (null === $this->baseUrl) {
            throw new RuntimeException('Base URL has not been set');
        }

        if (null === $this->pagination) {
            $itemsPerPage = array_key_exists('itemsPerPage', $options) ? (int) $options['itemsPerPage'] : 5;
            $this->pagination = new Pagination($items, $itemsPerPage, $this->baseUrl);
        }

        return $this->pagination;
    }
}
