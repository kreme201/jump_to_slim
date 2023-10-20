<?php

declare(strict_types=1);

namespace App\Application\Board\Actions;

use App\Application\Board\BoardService;
use App\Core\Abstracts\Action;
use Psr\Http\Message\ResponseInterface;

class BoardListAction extends Action
{
    public function __construct(
        private readonly BoardService $boardService,
    ) {
    }

    protected function action(): ResponseInterface
    {
        return $this->json($this->boardService->search());
    }
}
