<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Zentlix\Core\App\Shared\Application\Command\CommandHandlerInterface;
use Zentlix\Users\App\User\Domain\Repository\UserGroupRepositoryInterface;
use Zentlix\Users\App\User\Domain\Service\UserGroupValidatorInterface;
use Zentlix\Users\App\User\Domain\UserGroup;

final class CreateUserGroupHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserGroupRepositoryInterface $groupRepository,
        private readonly UserGroupValidatorInterface $validator
    ) {
    }

    public function __invoke(CreateUserGroupCommand $command): void
    {
        $this->groupRepository->store(new UserGroup($command, $this->validator));
    }
}
