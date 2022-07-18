<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventStore\Dbal\DBALEventStore;
use Broadway\EventStore\EventStore;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Core\App\Shared\Application\Query\QueryBusInterface;
use Zentlix\Users\App\Locale\Domain\Service\LocaleValidatorInterface;
use Zentlix\Users\App\Locale\Domain\Specification\UniqueCodeSpecificationInterface;
use Zentlix\Users\App\Locale\Infrastructure\Service\LocaleValidator;
use Zentlix\Users\App\User\Infrastructure\Auth\AuthProvider;
use Zentlix\Users\App\User\Infrastructure\Auth\Guard\AdminAuthenticator;
use Zentlix\Users\App\User\Infrastructure\Auth\Guard\PersonalAuthenticator;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserRepository;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->alias(EventStore::class, DBALEventStore::class)

        ->set(LocaleValidatorInterface::class, LocaleValidator::class)
            ->args([
                service(ValidatorInterface::class),
                service(UniqueCodeSpecificationInterface::class),
            ])

        ->set(AuthProvider::class)
            ->args([
                service(DoctrineUserRepository::class),
            ])

        ->set(AdminAuthenticator::class)
            ->args([
                service(CommandBusInterface::class),
                service(QueryBusInterface::class),
                service('router'),
            ])

        ->set(PersonalAuthenticator::class)
            ->args([
                service(CommandBusInterface::class),
                service(QueryBusInterface::class),
                service('router'),
            ])
    ;
};
