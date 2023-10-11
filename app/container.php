<?php declare(strict_types=1);

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAttributes(true);
$containerBuilder->addDefinitions([

]);

return $containerBuilder->build();
