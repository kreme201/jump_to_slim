<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use DI\ContainerBuilder;

$config = require __DIR__.'/../config.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAttributes(true);
$containerBuilder->addDefinitions([
    PDO::class => new PDO("mysql:host={$config['db.host']};dbname={$config['db.name']};port={$config['db.port']};charset={$config['db.charset']}",
        $config['db.username'], $config['db.password']),
]);

return $containerBuilder->build();
