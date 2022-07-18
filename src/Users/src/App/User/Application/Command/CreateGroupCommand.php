<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints;
use Zentlix\Core\App\Shared\Application\Command\CreateCommandInterface;
use Zentlix\Users\App\User\Domain\Role;

final class CreateGroupCommand extends GroupCommand implements CreateCommandInterface
{
    /** @psalm-readonly */
    #[Constraints\Uuid]
    public readonly Uuid $uuid;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->role = Role::USER;
    }
}
