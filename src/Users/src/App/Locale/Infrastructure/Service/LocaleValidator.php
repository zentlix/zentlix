<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Infrastructure\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zentlix\Users\App\Locale\Application\Command\CreateCommand;
use Zentlix\Users\App\Locale\Domain\Exception\CodeAlreadyExistException;
use Zentlix\Users\App\Locale\Domain\Exception\LocaleValidationException;
use Zentlix\Users\App\Locale\Domain\Service\LocaleValidatorInterface;
use Zentlix\Users\App\Locale\Domain\Specification\UniqueCodeSpecificationInterface;

class LocaleValidator implements LocaleValidatorInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private UniqueCodeSpecificationInterface $uniqueCodeSpecification
    ) {
    }

    /**
     * @throws LocaleValidationException
     * @throws CodeAlreadyExistException
     */
    public function preCreate(CreateCommand $command): void
    {
        $errors = $this->validator->validate($command);
        if ($errors->count() > 0) {
            throw new LocaleValidationException($errors);
        }

        $this->uniqueCodeSpecification->isUnique($command->code);
    }
}
