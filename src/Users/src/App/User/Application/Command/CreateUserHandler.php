<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zentlix\Core\App\Shared\Application\Command\CommandHandlerInterface;
use Zentlix\Users\App\User\Domain\Repository\UserRepositoryInterface;
use Zentlix\Users\App\User\Domain\Service\UserValidatorInterface;
use Zentlix\Users\App\User\Domain\User;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserView;

final class CreateUserHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserValidatorInterface $validator,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $command->password = $this->passwordHasher->hashPassword(new UserView(), $command->password);

        $this->userRepository->store(new User($command, $this->validator));
    }
}
