<?php

declare(strict_types=1);

namespace App\Domain\Member;

use JsonSerializable;

class Member implements JsonSerializable
{
    public function __construct(
        private int $id,
        private string $email,
        private string $password,
        private string $name,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ];
    }
}
