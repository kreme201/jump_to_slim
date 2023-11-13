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
        $data = $this->boardService->get((int) $this->args['id'] ?? 0);

        if ($data["author"] !== $_SESSION["user_id"]) {
            return $this->response->withStatus(404);
        }

        if ($this->isPost()) {
            $this->boardService->delete($data['id']);

            return $this->redirectByName('board_list');
        }

        return $this->view('board/delete.twig', [
            'data' => $data,
        ]);
    }
}
