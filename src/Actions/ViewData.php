<?php

declare(strict_types=1);

namespace App\Actions;

class ViewData
{
    public function __construct(
        private array $data = [],
    ) {
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setAttribute(string $key, mixed $data) {
        $this->data[$key] = $data;
    }
}
