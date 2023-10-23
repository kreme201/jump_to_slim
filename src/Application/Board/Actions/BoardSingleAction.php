<?php

declare(strict_types=1);

namespace App\Application\Board\Actions;

use App\Application\Board\BoardService;
use App\Core\Abstracts\Action;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;

class BoardSingleAction extends Action
{
    public function __construct(
        private readonly BoardService $boardService,
    ) {
    }

    protected function action(): ResponseInterface
    {
        try {
            $data = $this->boardService->get((int) $this->args['id'] ?? 0);

            return $this->view('board/single.twig', ['data' => $data]);
        } catch (Exception $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }
}
