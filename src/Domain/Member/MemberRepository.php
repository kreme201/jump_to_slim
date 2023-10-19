<?php
declare(strict_types=1);

namespace App\Domain\Member;

interface MemberRepository
{
    public function search(): array;

    public function create(array $params): Member;

    public function get(int $id): Member;

    public function update(int $id, array $params): Member;

    public function delete(int $id): bool;
}
