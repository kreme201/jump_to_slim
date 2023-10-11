<?php declare(strict_types=1);

use App\Actions\Home\HomeAction;
use Slim\Factory\AppFactory;

$container = require __DIR__ . '/container.php';

$app = AppFactory::createFromContainer($container);

$app->get('/', HomeAction::class);


$app->run();
