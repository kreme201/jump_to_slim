<?php

declare(strict_types=1);

namespace App\Application\Board\Actions;

use App\Application\Board\BoardService;
use App\Core\Abstracts\Action;
use Psr\Http\Message\ResponseInterface;

class BoardFormAction extends Action
{
    public function __construct(
        private readonly BoardService $boardService,
    ) {
    }

    protected function action(): ResponseInterface
    {
        $boardId = (int) ($this->args['id'] ?? 0);
        $data = [];

        if ($this->isPost()) {
            $data = (array) $this->request->getParsedBody();

            if (empty($data['title'])) {
                $data['error'] = 'TITLE IS REQUIRED';
            } elseif (empty($data['content'])) {
                $data['error'] = 'CONTENT IS REQUIRED';
            } else {
                if ($boardId > 0) {
                    $result = $this->boardService->update($boardId, $data['title'], $data['content']);
                } else {
                    $result = $this->boardService->create($data['title'], $data['content']);
                }

                if ($result > 0) {
                    if ($boardId > 0) {
                        return $this->redirectByName('board_single', ['id' => $result]);
                    } else {
                        return $this->redirectByName('board_list');
                    }
                }

                $data['error'] = 'Unknown Error';
            }
        } elseif (!empty($boardId)) {
            $data = $this->boardService->get($boardId);

            if ($data["author"] !== $_SESSION["user_id"]) {
                return $this->response->withStatus(404);
            }
        }

        return $this->view('board/form.twig', $data);
    }
}
