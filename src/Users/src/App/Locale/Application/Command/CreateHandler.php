<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Application\Command;

use Zentlix\Core\App\Shared\Application\Command\CommandHandlerInterface;
use Zentlix\Users\App\Locale\Domain\Locale;
use Zentlix\Users\App\Locale\Domain\Repository\LocaleRepositoryInterface;
use Zentlix\Users\App\Locale\Domain\Service\LocaleValidatorInterface;

final class CreateHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly LocaleRepositoryInterface $localeRepository,
        private readonly LocaleValidatorInterface $validator
    ) {
    }

    public function __invoke(CreateCommand $command): void
    {
        $this->localeRepository->store(new Locale($command, $this->validator));
    }
}
