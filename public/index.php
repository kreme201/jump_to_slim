<?php

declare(strict_types=1);

use App\Application\Board\Actions\BoardDeleteAction;
use App\Application\Board\Actions\BoardFormAction;
use App\Application\Board\Actions\BoardListAction;
use App\Application\Board\Actions\BoardSingleAction;
use App\Application\Member\Actions\MemberFormAction;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$container = require __DIR__.'/../config/container.php';

$app = AppFactory::createFromContainer($container);

// Create Twig
$twig = Twig::create(dirname(__DIR__).'/templates', ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));
$app->getContainer()->set(Twig::class, $twig);

$app->redirect('/', '/board', 301);

$app->group('/board', function (RouteCollectorProxyInterface $group) {
    $group->get('', BoardListAction::class)->setName('board_list');
    $group->map(['GET', 'POST'], '/register', BoardFormAction::class)->setName('board_register');
    $group->get('/{id}', BoardSingleAction::class)->setName('board_single');
    $group->map(['GET', 'POST'], '/{id}/edit', BoardFormAction::class)->setName('board_edit');
    $group->map(['GET', 'POST'], '/{id}/delete', BoardDeleteAction::class)->setName('board_delete');
});

$app->group('/member', function (RouteCollectorProxyInterface $group) {
    $group->map(['GET', 'POST'], '/register', MemberFormAction::class)->setName('member_register');
});


$app->run();
