<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Auth;

use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Exception\NotFoundException;
use Zentlix\Users\App\User\Domain\ValueObject\Email;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserRepository;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserView;

final class AuthProvider implements UserProviderInterface
{
    public function __construct(
        private readonly DoctrineUserRepository $userReadModelRepository
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        try {
            return $this->userReadModelRepository->getByEmail(Email::fromString($identifier));
        } catch (NotFoundException) {
            throw new UserNotFoundException();
        }
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return UserView::class === $class;
    }
}
