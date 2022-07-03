<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventHandling\EventListener;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zentlix\Users\App\Locale\Domain\Service\LocaleValidatorInterface;
use Zentlix\Users\App\Locale\Domain\Specification\UniqueCodeSpecificationInterface;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Projections\LocaleProjectionFactory;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\DoctrineLocaleRepository;
use Zentlix\Users\App\Locale\Infrastructure\Service\LocaleValidator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->instanceof(EventListener::class)
            ->tag('broadway.domain.event_listener')

        ->set(LocaleValidatorInterface::class, LocaleValidator::class)
            ->args([
                service(ValidatorInterface::class),
                service(UniqueCodeSpecificationInterface::class),
            ])

        ->set(LocaleProjectionFactory::class)
            ->args([
                service(DoctrineLocaleRepository::class),
            ])
    ;
};
