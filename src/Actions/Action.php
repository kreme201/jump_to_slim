<?php
declare(strict_types=1);

namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Action
{
    protected ServerRequestInterface $request;
    protected ResponseInterface $response;
    protected array $args;

    final public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $this->request = $request;
        $this->response=$response;
        $this->args=$args;

        return $this->action();
    }

    abstract protected function action(): ResponseInterface;

    protected function message(string $message): ResponseInterface {
        $this->response->getBody()->write($message);
        return $this->response;
    }

    protected function json(array $data): ResponseInterface {
        $this->response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $this->response->withHeader('Content-Type', 'application/json');
    }
}
