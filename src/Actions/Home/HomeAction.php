<?php
declare(strict_types=1);

namespace App\Actions\Home;

use App\Actions\Action;
use Psr\Http\Message\ResponseInterface;

class HomeAction extends Action
{

    protected function action(): ResponseInterface
    {
        // return $this->message('Hello World from action');
        return $this->json([
            'message' => 'hello json',
        ]);
    }
}
