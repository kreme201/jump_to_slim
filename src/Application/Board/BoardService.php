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
            'title'   => $title,
            'content' => $content,
        ]);
    }

    public function update(int $id, string $title, string $content): int
    {
        return $this->boardRepository->update($id, [
            'title'   => $title,
            'content' => $content,
        ]);
    }

    public function delete(int $id): void
    {
        $this->boardRepository->delete($id);
    }

    public function search(string $search = ''): array
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
