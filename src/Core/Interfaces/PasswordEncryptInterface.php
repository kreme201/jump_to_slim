<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

interface PasswordEncryptInterface
{
    function hash(string $value): string;

    function verify(string $password, string $hash): bool;
}
