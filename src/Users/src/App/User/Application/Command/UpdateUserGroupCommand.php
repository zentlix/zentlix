<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Zentlix\Core\App\Shared\Application\Command\UpdateCommandInterface;
use Zentlix\Users\App\User\Domain\UserGroup;

final class UpdateUserGroupCommand extends UserGroupCommand implements UpdateCommandInterface
{
    public function __construct(UserGroup $group)
    {
        $this->title = $group->getTitle();
        $this->code = $group->getCode();
        $this->role = $group->getRole();
        $this->rights = $group->getRights();
        $this->sort = $group->getSort();

        foreach ($group->getRights() as $class => $isGranted) {
            $this->__set($class, $isGranted);
        }
    }

    public function __get(string $right): bool
    {
        if ($this->__isset($right)) {
            return $this->rights[str_replace(':', '\\', $right)];
        }

        return false;
    }

    public function __set(string $right, bool $isGranted): void
    {
        $this->rights[str_replace(':', '\\', $right)] = $isGranted;
    }

    public function __isset(string $right): bool
    {
        return isset($this->rights[str_replace(':', '\\', $right)]);
    }
}
