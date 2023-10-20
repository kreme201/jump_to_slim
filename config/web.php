<?php declare(strict_types=1);

use App\Actions\Home\HomeAction;
use App\Actions\Member\MemberRegisterAction;
use App\Middlewares\TwigGlobalEnvMiddleware;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$container = require __DIR__ . '/container.php';

$app = AppFactory::createFromContainer($container);

// Create Twig
$twig = Twig::create(dirname(__DIR__) . '/templates', ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));
$app->add(TwigGlobalEnvMiddleware::class);
$app->getContainer()->set(Twig::class, $twig);

$app->get('/', HomeAction::class);
$app->get('/member/register', MemberRegisterAction::class);
$app->post('/member/register', MemberRegisterAction::class);

$app->run();
