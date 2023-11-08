<?php

declare(strict_types=1);

namespace App\Application\Member\Actions;

use App\Core\Abstracts\Action;
use Psr\Http\Message\ResponseInterface;

class MemberLogoutAction extends Action
{
    protected function action(): ResponseInterface
    {
        if ($_SESSION['user_id']) {
            unset($_SESSION['user_id']);
        }

        return $this->redirectByName('board_list');
    }
}
