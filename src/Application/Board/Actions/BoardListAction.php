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
        $search = $this->request->getQueryParams()['search'] ?? '';
        $data = $this->boardService->search($search);

        return $this->view('board/list.twig', [
            'data'   => $data,
            'search' => $search,
        ]);
    }
}
