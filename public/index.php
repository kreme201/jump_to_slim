<?php

declare(strict_types=1);

use App\Application\Board\Actions\BoardListAction;
use App\Application\Board\Actions\BoardSingleAction;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$container = require __DIR__.'/../config/container.php';

$app = AppFactory::createFromContainer($container);

// Create Twig
$twig = Twig::create(dirname(__DIR__).'/templates', ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));
$app->getContainer()->set(Twig::class, $twig);

$app->get('/', BoardListAction::class);
$app->get('/{id}', BoardSingleAction::class);

$app->run();
