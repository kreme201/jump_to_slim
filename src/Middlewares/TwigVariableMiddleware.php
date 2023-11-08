<?php

declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

class TwigVariableMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly Twig $twig,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->twig->getEnvironment()->addGlobal('user_id', $_SESSION['user_id'] ?? '');

        return $handler->handle($request);
    }
}
