<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventStore\Dbal\DBALEventStore;
use Broadway\EventStore\EventStore;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zentlix\Users\App\Locale\Domain\Service\LocaleValidatorInterface;
use Zentlix\Users\App\Locale\Domain\Specification\UniqueCodeSpecificationInterface;
use Zentlix\Users\App\Locale\Infrastructure\Service\LocaleValidator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->alias(EventStore::class, DBALEventStore::class)

        ->set(LocaleValidatorInterface::class, LocaleValidator::class)
            ->args([
                service(ValidatorInterface::class),
                service(UniqueCodeSpecificationInterface::class),
            ])
    ;
};
