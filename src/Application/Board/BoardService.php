<?php

declare(strict_types=1);

namespace App\Application\Board;

use Exception;

class BoardService
{
    public function __construct(
        private readonly BoardRepository $boardRepository,
    ) {
    }

    public function search(string $search = '')
    {
        $result = $this->boardRepository->search($search);

        if ($result === false) {
            return [];
        }

        return $result;
    }

    public function get(int $id)
    {
        $result = $this->boardRepository->get($id);

        if ($result === false) {
            throw new Exception('Board not Found');
        }

        return $result;
    }
}
