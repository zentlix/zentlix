<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Core\App\Shared\Application\Query\QueryBusInterface;
use Zentlix\Users\UI\Http\Rest\Controller\LocaleController;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->defaults()
            ->public()

        ->set(LocaleController::class)
            ->args([
                service(QueryBusInterface::class),
                service('router'),
            ])
            ->tag('controller.service_arguments')
    ;
};
