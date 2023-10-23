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
        $boardId = (int)$this->args['id'] ?? 0;

        if (!empty($boardId)) {
            $data = $this->boardService->get($boardId);
        }
        $params = (array)$this->request->getParsedBody();

        if ($this->isPost()) {
            if (empty($params['title'])) {
                $data['title'] = '';
                $data['error'] = 'TITLE IS REQUIRED';
            } elseif (empty($params['content'])) {
                $data['content'] = '';
                $data['error'] = 'CONTENT IS REQUIRED';
            } else {
                if ($boardId > 0) {
                    $result = $this->boardService->update($boardId, $params['title'], $params['content']);
                } else {
                    $result = $this->boardService->create($params['title'], $params['content']);
                }

                if ($result > 0) {
                    return $this->redirectByName('board_single', ['id' => $result]);
                }

                $data['error'] = 'Unknown Error';
            }
        }

        return $this->view('board/form.twig', $data);
    }
}
