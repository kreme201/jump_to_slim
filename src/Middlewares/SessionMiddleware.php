<?php

declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!session_id()) {
            session_start();
            // $request->withAttribute('session', $_SESSION);
        }

        $response = $handler->handle($request);

        if (session_id()) {
            // session_write_close();
        }

        return $response;
    }
}
