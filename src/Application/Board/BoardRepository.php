<?php

declare(strict_types=1);

namespace App\Application\Board;

use App\Core\Abstracts\Repository;

class BoardRepository extends Repository
{
    protected string $table = 'board';

    public function search(string $search = ''): false|array
    {
        return $this->getResult("SELECT * FROM {$this->table} WHERE title LIKE :search", [
            'search' => "%{$search}%",
        ]);
    }

    public function get(int $id): false|array
    {
        return $this->getRow("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }
}
