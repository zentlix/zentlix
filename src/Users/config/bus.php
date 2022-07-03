<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Core\App\Shared\Application\Command\CommandHandlerInterface;
use Zentlix\Users\App\Locale\Application\Command\CreateHandler;
use Zentlix\Users\App\Locale\Domain\Repository\LocaleRepositoryInterface;
use Zentlix\Users\App\Locale\Domain\Service\LocaleValidatorInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->instanceof(CommandHandlerInterface::class)
            ->tag('messenger.message_handler', ['bus' => 'messenger.bus.command'])

        ->set('zentlix_users.attribute.create_handler', CreateHandler::class)
            ->args([
                service(LocaleRepositoryInterface::class),
                service(LocaleValidatorInterface::class),
            ])

    ;
};
