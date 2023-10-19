<?php
declare(strict_types=1);

namespace App\Actions;

use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

abstract class Action
{
    protected ServerRequestInterface $request;
    protected ResponseInterface $response;
    protected array $args;
    #[Inject]
    protected ViewData $viewData;

    final public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        return $this->action();
    }

    abstract protected function action(): ResponseInterface;

    protected function message(string $message): ResponseInterface
    {
        $this->response->getBody()->write($message);

        return $this->response;
    }

    protected function json(array $data): ResponseInterface
    {
        $this->response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));

        return $this->response->withHeader('Content-Type', 'application/json');
    }

    protected function view(string $path, array $data = []): ResponseInterface
    {
        $twig = Twig::fromRequest($this->request);

        return $twig->render($this->response, $path, array_merge($this->viewData->getData(), $data));
    }
}
