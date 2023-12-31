<?php

declare(strict_types=1);

namespace App\Core\Abstracts;

use PDO;
use PDOStatement;

abstract class Repository
{
    protected string $primaryKey = 'id';
    protected string $table;

    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    public function insert(array $params): int
    {
        $data = array_filter($params, function ($key) {
            return $key !== $this->primaryKey;
        }, ARRAY_FILTER_USE_KEY);

        $columns = implode(', ', array_map(function ($column) {
            return "`{$column}`";
        }, array_keys($data)));

        $values = implode(', ', array_map(function ($column) {
            return ":{$column}";
        }, array_keys($data)));

        $sql = "INSERT INTO `{$this->table}` ({$columns}) VALUES ({$values})";

        $this->query($sql, $data);

        return (int) $this->pdo->lastInsertId();
    }

    protected function query(string $sql, array $params): PDOStatement
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($params);

        return $query;
    }

    public function update(int $id, array $params): int
    {
        $data = array_filter($params, function ($key) {
            return $key !== $this->primaryKey;
        }, ARRAY_FILTER_USE_KEY);

        $columns = implode(', ', array_map(function ($columns) {
            return "`{$columns}` = :{$columns}";
        }, array_keys($data)));
        $sql = "UPDATE `{$this->table}` SET {$columns} WHERE `{$this->primaryKey}` = :primaryKey";
        $params['primaryKey'] = $id;

        $this->query($sql, $params);

        return $id;
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM `{$this->table}` WHERE `{$this->primaryKey}` = :id";

        $this->query($sql, ['id' => $id]);
    }

    public function get(int $id): false|array
    {
        return $this->getRow("SELECT * FROM `{$this->table}` WHERE `{$this->primaryKey}` = :id", [
            'id' => $id,
        ]);
    }

    protected function getRow(string $sql, array $params = []): false|array
    {
        return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    protected function getResult(string $sql, array $params = []): false|array
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getValue(string $sql, array $params = []): mixed
    {
        return $this->query($sql, $params)->fetchColumn(0);
    }
}
