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

    public function create(string $title, string $content): int
    {
        return $this->boardRepository->insert([
            'author'  => $_SESSION['user_id'],
            'title'   => $title,
            'content' => $content,
            'created' => date('Y-m-d H:i:s'),
            'updated' => date('Y-m-d H:i:s'),
        ]);
    }

    public function update(int $id, string $title, string $content): int
    {
        return $this->boardRepository->update($id, [
            'title'   => $title,
            'content' => $content,
            'updated' => date('Y-m-d H:i:s'),
        ]);
    }

    public function delete(int $id): void
    {
        $this->boardRepository->delete($id);
    }

    public function search(string $search = '', int $rpp = 10, int $page = 1): array
    {
        $result = $this->boardRepository->search($search, $rpp, max(0, $page - 1) * $rpp);

        if ($result === false) {
            return [];
        }

        return $result;
    }

    public function count(string $search = ''): int
    {
        return $this->boardRepository->count($search);
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
