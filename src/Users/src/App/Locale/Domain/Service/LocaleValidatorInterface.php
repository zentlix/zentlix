<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain\Service;

use Zentlix\Users\App\Locale\Application\Command\CreateCommand;
use Zentlix\Users\App\Locale\Domain\Exception\CodeAlreadyExistException;
use Zentlix\Users\App\Locale\Domain\Exception\LocaleValidationException;

interface LocaleValidatorInterface
{
    /**
     * @throws LocaleValidationException
     * @throws CodeAlreadyExistException
     */
    public function preCreate(CreateCommand $command): void;
}
