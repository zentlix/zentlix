<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Core\App\Shared\Application\Query\QueryBusInterface;
use Zentlix\Users\UI\Http\Rest\Controller as Rest;
use Zentlix\Users\UI\Http\Web\Controller\Admin;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->defaults()
            ->public()

        ->set(Admin\SecurityController::class)
            ->args([
                service('twig'),
                service(CommandBusInterface::class),
                service(QueryBusInterface::class),
                service('router'),
            ])
            ->tag('controller.service_arguments')

        ->set(Rest\LocaleController::class)
            ->args([
                service(QueryBusInterface::class),
                service('router'),
            ])
            ->tag('controller.service_arguments')
    ;
};
