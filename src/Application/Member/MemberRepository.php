<?php

declare(strict_types=1);

namespace App\Application\Member;

use App\Core\Abstracts\Repository;

class MemberRepository extends Repository
{
    protected string $table = 'member';

    public function find_by_email(string $email): false|array
    {
        $sql = "SELECT * FROM {$this->table} WHERE `email` = :email";
        $params = ['email' => $email];

        return $this->getRow($sql, $params);
    }
}
