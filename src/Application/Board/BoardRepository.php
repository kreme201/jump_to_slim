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
        $sql = "SELECT * FROM {$this->table} ".$result['sql'];
        $params = $result['params'];

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
            "sql"    => "WHERE title LIKE :search OR content LIKE :search",
            "params" => ['search' => "%{$search}%"],
        ];
    }

    public function count(string $search = '')
    {
        $result = $this->search_base_query($search);
        $sql = "SELECT COUNT(*) FROM {$this->table} ".$result['sql'];
        $params = $result['params'];

        return (int) $this->getValue($sql, $params);
    }
}
