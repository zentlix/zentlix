<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Users\UI\Cli\Command;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set(Command\CreateLocaleCommand::class)
            ->args([
                service(CommandBusInterface::class),
            ])
            ->tag('console.command')

        ->set(Command\CreateUserGroupCommand::class)
            ->args([
                service(CommandBusInterface::class),
            ])
            ->tag('console.command')
    ;
};
