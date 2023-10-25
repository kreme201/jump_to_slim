<?php

declare(strict_types=1);

namespace App\Application\Board;

use App\Core\Abstracts\Repository;

class BoardRepository extends Repository
{
    protected string $table = 'board';

    public function search(string $search = ''): false|array
    {
        return $this->getResult("SELECT * FROM {$this->table} WHERE title LIKE :search OR content LIKE :search", [
            'search' => "%{$search}%",
        ]);
    }
}
