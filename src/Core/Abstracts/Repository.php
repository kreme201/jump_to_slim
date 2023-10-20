<?php

declare(strict_types=1);

namespace App\Core\Abstracts;

use PDO;
use PDOStatement;

abstract class Repository
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    protected function getResult(string $sql, array $params = []): false|array
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query(string $sql, array $params): PDOStatement
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($params);

        return $query;
    }

    protected function getRow(string $sql, array $params = []): false|array
    {
        return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }
}
