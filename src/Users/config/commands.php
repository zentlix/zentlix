<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Users\UI\Cli\Command\CreateLocaleCommand;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set(CreateLocaleCommand::class)
            ->args([
                service(CommandBusInterface::class),
            ])
            ->tag('console.command')
    ;
};
