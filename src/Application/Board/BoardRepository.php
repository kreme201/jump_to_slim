<?php

declare(strict_types=1);

namespace App\Application\Board;

use App\Core\Abstracts\Repository;

class BoardRepository extends Repository
{
    protected string $table = 'board';

    public function search(string $search = '', int $rpp = 10, int $offset = 0): false|array
    {
        $result = $this->search_base_query($search);
        $sql = "SELECT {$this->table}.*, member.name FROM {$this->table} INNER JOIN member ON member.id = {$this->table}.author ".$result['sql'];
        $params = $result['params'];

        $sql .= " ORDER BY board.id DESC";

        if ($rpp > 0) {
            $sql .= " LIMIT {$rpp}";

            if ($offset > 0) {
                $sql .= " OFFSET {$offset}";
            }
        }

        return $this->getResult($sql, $params);
    }

    private function search_base_query(string $search): array
    {
        return [
            "sql"    => "WHERE {$this->table}.title LIKE :search OR {$this->table}.content LIKE :search OR member.name LIKE :search",
            "params" => ['search' => "%{$search}%"],
        ];
    }

    public function count(string $search = '')
    {
        $result = $this->search_base_query($search);
        $sql = "SELECT COUNT(*) FROM {$this->table} INNER JOIN member ON member.id = board.author ".$result['sql'];
        $params = $result['params'];

        return (int) $this->getValue($sql, $params);
    }
}
