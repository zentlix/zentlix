<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zentlix\Users\App\User\Application\Command\CreateUserGroupCommand;
use Zentlix\Users\App\User\Domain\Exception\CodeAlreadyExistException;
use Zentlix\Users\App\User\Domain\Exception\UserGroupValidationException;
use Zentlix\Users\App\User\Domain\Service\UserGroupValidatorInterface;
use Zentlix\Users\App\User\Domain\Specification\UniqueCodeSpecificationInterface;

class UserGroupValidator implements UserGroupValidatorInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private UniqueCodeSpecificationInterface $uniqueCodeSpecification
    ) {
    }

    /**
     * @throws UserGroupValidationException
     * @throws CodeAlreadyExistException
     */
    public function preCreate(CreateUserGroupCommand $command): void
    {
        $errors = $this->validator->validate($command);
        if ($errors->count() > 0) {
            throw new UserGroupValidationException($errors);
        }

        $this->uniqueCodeSpecification->isUnique($command->code);
    }
}
