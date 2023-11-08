<?php

declare(strict_types=1);

namespace App\Infrastructure;

readonly class Pagination
{
    public function __construct(
        private int $total,
        private int $rpp,
        private int $currentPage,
    ) {
    }

    public function getPrev(): int
    {
        return max(1, $this->currentPage - 1);
    }

    public function getNext(): int
    {
        return min($this->getTotalPages(), $this->currentPage + 1);
    }

    public function getTotalPages(): int
    {
        return (int) ($this->total > $this->rpp ? ceil($this->total / $this->rpp) : 1);
    }

    public function getPagination(): array
    {
        $result = [];

        for (
            $i = max(1, $this->currentPage - 5); $i <= min($this->getTotalPages(),
            max(10, $this->currentPage + 5)); $i++
        ) {
            $result[] = $i;
        }

        return $result;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getRpp(): int
    {
        return $this->rpp;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }
}
