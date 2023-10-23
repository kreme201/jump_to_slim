<?php

declare(strict_types=1);

namespace App\Application\Board\Actions;

use App\Application\Board\BoardService;
use App\Core\Abstracts\Action;
use Psr\Http\Message\ResponseInterface;

class BoardDeleteAction extends Action
{
    public function __construct(
        private readonly BoardService $boardService,
    ) {
    }

    protected function action(): ResponseInterface
    {
        if ($this->isPost()) {
            $this->boardService->delete((int) $this->args['id'] ?? 0);

            return $this->redirectByName('board_list');
        }

        return $this->view('board/delete.twig');
    }
}
