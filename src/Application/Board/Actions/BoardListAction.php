<?php

declare(strict_types=1);

namespace App\Application\Board\Actions;

use App\Application\Board\BoardService;
use App\Core\Abstracts\Action;
use App\Infrastructure\Pagination;
use Psr\Http\Message\ResponseInterface;

class BoardListAction extends Action
{
    public function __construct(
        private readonly BoardService $boardService,
    ) {
    }

    protected function action(): ResponseInterface
    {
        $rpp = 10;
        $page = max(1, (int) ($this->request->getQueryParams()['page'] ?? 1));

        $search = $this->request->getQueryParams()['search'] ?? '';
        $total = $this->boardService->count($search);
        $data = $this->boardService->search($search, $rpp, $page);

        return $this->view('board/list.twig', [
            'data'       => $data,
            'search'     => $search,
            'pagination' => new Pagination($total, $rpp, $page),
        ]);
    }
}
