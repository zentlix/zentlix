<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Zentlix\Core\App\Shared\Application\Command\UpdateCommandInterface;
use Zentlix\Users\App\User\Domain\User;
use Zentlix\Users\App\User\Domain\UserGroup;

final class UpdateUserCommand extends UserCommand implements UpdateCommandInterface
{
    public function __construct(User $user)
    {
        $this->email = $user->getEmail();
        $this->firstName = $user->getFirstName();
        $this->lastName = $user->getLastName();
        $this->middleName = $user->getMiddleName();
        $this->status = $user->getStatus();
        $this->locale = $user->getLocale()?->getUuid()->toRfc4122();
        $this->updatedAt = new \DateTimeImmutable();

        /** @var UserGroup $group */
        foreach ($user->getGroups() as $group) {
            $this->groups[$group->getCode()] = $group->getTitle();
        }
        $this->groups = array_flip($this->groups);
    }
}
