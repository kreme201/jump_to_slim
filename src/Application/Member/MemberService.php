<?php

declare(strict_types=1);

namespace App\Application\Member;

use App\Core\Interfaces\PasswordEncryptInterface;

class MemberService
{
    public function __construct(
        private readonly MemberRepository $memberRepository,
        private readonly PasswordEncryptInterface $passwordEncrypt,
    ) {
    }

    public function search()
    {
    }

    public function get(int $id): false|array
    {
        return $this->memberRepository->get($id);
    }

    public function find_by_email(string $email): array
    {
        $result = $this->memberRepository->find_by_email($email);

        if ($result) {
            return $result;
        }

        return [];
    }

    public function add(string $email, string $name, string $password): int
    {
        return $this->memberRepository->insert([
            'email'    => $email,
            'name'     => $name,
            'password' => $this->passwordEncrypt->hash($password),
            'created'  => date('Y-m-d H:i:s'),
            'updated'  => date('Y-m-d H:i:s'),
        ]);
    }

    public function update(int $id, string $name, string $password): int
    {
        return $this->memberRepository->update($id, [
            'name'     => $name,
            'password' => $this->passwordEncrypt->hash($password),
        ]);
    }

    public function delete(int $id): void
    {
        $this->memberRepository->delete($id);
    }
}
