<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\UserGroupRepositoryInterface;
use Zentlix\Users\UI\Cli\Command;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set(Command\CreateLocaleCommand::class)
            ->args([
                service(CommandBusInterface::class),
            ])
            ->tag('console.command')

        ->set(Command\CreateUserCommand::class)
            ->args([
                service(CommandBusInterface::class),
                service(UserGroupRepositoryInterface::class),
            ])
            ->tag('console.command')

        ->set(Command\CreateUserGroupCommand::class)
            ->args([
                service(CommandBusInterface::class),
            ])
            ->tag('console.command')
    ;
};
