<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventHandling\EventListener;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Projections\LocaleProjectionFactory;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\DoctrineLocaleRepository;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\LocaleRepositoryInterface;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Projections\UserGroupProjectionFactory;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Projections\UserProjectionFactory;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserGroupRepository;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserRepository;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\UserGroupRepositoryInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->instanceof(EventListener::class)
            ->tag('broadway.domain.event_listener')

        ->set(LocaleProjectionFactory::class)
            ->args([
                service(DoctrineLocaleRepository::class),
            ])

        ->set(UserGroupProjectionFactory::class)
            ->args([
                service(DoctrineUserGroupRepository::class),
            ])

        ->set(UserProjectionFactory::class)
            ->args([
                service(DoctrineUserRepository::class),
                service(UserGroupRepositoryInterface::class),
                service(LocaleRepositoryInterface::class),
            ])
    ;
};
