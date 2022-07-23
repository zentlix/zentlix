<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Symfony\Component\Validator\Constraints;
use Zentlix\Users\App\User\Domain\Role;

class UserGroupCommand
{
    /** @psalm-var non-empty-string */
    #[Constraints\NotBlank]
    public string $title;

    /** @psalm-var non-empty-string */
    #[Constraints\NotBlank]
    public string $code;

    /** @psalm-var positive-int */
    #[Constraints\NotBlank]
    #[Constraints\Positive]
    public int $sort = 1;

    public Role $role;

    public array $rights = [];
}
