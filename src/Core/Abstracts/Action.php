<?php

declare(strict_types=1);

namespace App\Core\Abstracts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

abstract class Action
{
    protected ServerRequestInterface $request;
    protected ResponseInterface $response;
    protected array $args;

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

    protected function isPost(): bool
    {
        return $this->request->getMethod() === 'POST';
    }

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
        return Twig::fromRequest($this->request)->render($this->response, $path, $data);
    }

    protected function redirectByName(string $name, array $params = [], int $status = 302): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($this->request);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor($name, $params);

        return $this->redirect($url, $status);
    }

    protected function redirect(string $path, int $status = 302): ResponseInterface
    {
        return $this->response->withHeader('Location', $path)->withStatus($status);
    }
}
