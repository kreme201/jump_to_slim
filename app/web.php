<?php declare(strict_types=1);

use App\Application\Actions\Home\HomeAction;
use App\Controller\HomeController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;

$container = require __DIR__ . '/container.php';

$app = AppFactory::createFromContainer($container);

$app->get('/', HomeAction::class);


$app->run();
