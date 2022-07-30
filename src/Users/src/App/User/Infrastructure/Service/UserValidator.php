<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zentlix\Users\App\User\Application\Command\CreateUserCommand;
use Zentlix\Users\App\User\Domain\Exception\CodeAlreadyExistException;
use Zentlix\Users\App\User\Domain\Exception\UserValidationException;
use Zentlix\Users\App\User\Domain\Exception\UserWithoutGroupException;
use Zentlix\Users\App\User\Domain\Service\UserValidatorInterface;
use Zentlix\Users\App\User\Domain\Specification\ExistUserGroupSpecificationInterface;
use Zentlix\Users\App\User\Domain\Specification\UniqueEmailSpecificationInterface;

class UserValidator implements UserValidatorInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private UniqueEmailSpecificationInterface $uniqueEmailSpecification,
        private ExistUserGroupSpecificationInterface $existUserGroupSpecification
    ) {
    }

    /**
     * @throws UserValidationException
     * @throws CodeAlreadyExistException
     */
    public function preCreate(CreateUserCommand $command): void
    {
        $errors = $this->validator->validate($command);
        if ($errors->count() > 0) {
            throw new UserValidationException($errors);
        }
        if (0 === $command->getGroups()->count()) {
            throw new UserWithoutGroupException();
        }

        $this->uniqueEmailSpecification->isUnique($command->getEmail());
        $this->existUserGroupSpecification->isExist($command->getGroups()->toArray());
    }
}
