<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Core\App\Shared\Application\Command\CommandHandlerInterface;
use Zentlix\Core\App\Shared\Application\Query\QueryHandlerInterface;
use Zentlix\Users\App\Locale\Application\Command\CreateHandler;
use Zentlix\Users\App\Locale\Application\Query\GetLocalesHandler;
use Zentlix\Users\App\Locale\Domain as LocaleDomain;
use Zentlix\Users\App\Locale\Infrastructure;
use Zentlix\Users\App\User\Application\Command\CreateUserGroupHandler;
use Zentlix\Users\App\User\Domain as UserDomain;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->instanceof(CommandHandlerInterface::class)
            ->tag('messenger.message_handler', ['bus' => 'messenger.bus.command'])

        ->instanceof(QueryHandlerInterface::class)
            ->tag('messenger.message_handler', ['bus' => 'messenger.bus.query'])

        ->set(CreateHandler::class)
            ->args([
                service(LocaleDomain\Repository\LocaleRepositoryInterface::class),
                service(LocaleDomain\Service\LocaleValidatorInterface::class),
            ])

        ->set(CreateUserGroupHandler::class)
            ->args([
                service(UserDomain\Repository\UserGroupRepositoryInterface::class),
                service(UserDomain\Service\UserGroupValidatorInterface::class),
            ])

        ->set(GetLocalesHandler::class)
            ->args([
                service(Infrastructure\ReadModel\Repository\LocaleRepositoryInterface::class),
            ])
    ;
};
