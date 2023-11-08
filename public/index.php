<?php

declare(strict_types=1);

use App\Application\Board\Actions\BoardDeleteAction;
use App\Application\Board\Actions\BoardFormAction;
use App\Application\Board\Actions\BoardListAction;
use App\Application\Board\Actions\BoardSingleAction;
use App\Application\Member\Actions\MemberFormAction;
use App\Application\Member\Actions\MemberLoginAction;
use App\Application\Member\Actions\MemberLogoutAction;
use App\Middlewares\SessionMiddleware;
use App\Middlewares\TwigVariableMiddleware;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$container = require __DIR__.'/../config/container.php';

$app = AppFactory::createFromContainer($container);

// Create Twig
$twig = Twig::create(dirname(__DIR__).'/templates', ['cache' => false]);
$app->getContainer()->set(Twig::class, $twig);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

$app->add(TwigVariableMiddleware::class);
$app->add(SessionMiddleware::class);

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
    $group->map(['GET', 'POST'], '/login', MemberLoginAction::class)->setName('member_login');
    $group->get('/logout', MemberLogoutAction::class)->setName('member_logout');
});


$app->run();
