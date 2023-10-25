<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Core\Interfaces\PasswordEncryptInterface;

class PasswordEncrypt implements PasswordEncryptInterface
{

    function hash(string $value): string
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
