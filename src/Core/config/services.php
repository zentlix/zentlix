<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventHandling\EventListener;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->instanceof(EventListener::class)
            ->tag('broadway.domain.event_listener')
    ;
};
