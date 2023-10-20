<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAttributes(true);
$containerBuilder->addDefinitions([
    PDO::class => new PDO('mysql:host=localhost;dbname=jump_to_slim;port=3306;charset=utf8mb4', 'root', '1234'),
]);

return $containerBuilder->build();
