<?php
declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

class TwigGlobalEnvMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Twig $twig,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->twig->getEnvironment()->addGlobal('test', '1234');

        return $handler->handle($request);
    }
}
