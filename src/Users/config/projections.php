<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventHandling\EventListener;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Projections\LocaleProjectionFactory;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\LocaleRepositoryInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->instanceof(EventListener::class)
            ->tag('broadway.domain.event_listener')

        ->set(LocaleProjectionFactory::class)
            ->args([
                service(LocaleRepositoryInterface::class),
            ])
    ;
};
