<?php

declare(strict_types=1);

namespace App\Application\Member;

use App\Core\Abstracts\Repository;

class MemberRepository extends Repository
{
    protected string $table = 'member';
}
