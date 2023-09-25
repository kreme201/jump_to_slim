<?php
declare(strict_types=1);

namespace App\Application\Actions\Home;

use App\Application\Actions\Action;
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
