<?php
declare(strict_types=1);

namespace App\Infrastructures\Persistance;

use App\Domain\Member\Member;
use App\Domain\Member\MemberRepository;
use Exception;

class MemoryMemberRepository implements MemberRepository
{
    public function __construct(
        private array $data = [],
    ) {
    }

    public function create(array $params): Member
    {
        $member = new Member(count($this->data) + 1, $params['email'], $params['password'], $params['name']);
        $this->data[] = $member;

        return $member;
    }

    public function search(): array
    {
        return $this->data;
    }

    public function update(int $id, array $params): Member
    {
        $member = $this->get($id);

        $member['name'] = $params['name'];
        $this->data[$id] = $member;

        return $member;
    }

    public function get(int $id): Member
    {
        if (isset($this->data[$id])) {
            return $this->data[$id];
        }

        throw new Exception('Member not found');
    }

    public function delete(int $id): bool
    {
        $this->data = array_filter($this->data, function ($key) use ($id) {
            return $key != $id;
        }, ARRAY_FILTER_USE_KEY);

        return true;
    }
}
