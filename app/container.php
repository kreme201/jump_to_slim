<?php declare(strict_types=1);

use App\Domain\Member\MemberRepository;
use App\Infrastructures\Persistance\MemoryMemberRepository;
use DI\Container;
use DI\ContainerBuilder;

use function DI\create;

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAttributes(true);
$containerBuilder->addDefinitions([
    MemberRepository::class => create(MemoryMemberRepository::class),
]);

return $containerBuilder->build();
