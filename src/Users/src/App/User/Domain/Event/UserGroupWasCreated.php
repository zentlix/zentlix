<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Event;

use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Domain\Event\AbstractSerializableEvent;
use Zentlix\Users\App\User\Domain\Role;

final class UserGroupWasCreated extends AbstractSerializableEvent
{
    public function __construct(
        public Uuid $uuid,

        /** @psalm-var non-empty-string */
        public string $title,

        /** @psalm-var non-empty-string */
        public string $code,

        /** @psalm-var positive-int */
        public int $sort,

        public Role $role,

        public array $rights
    ) {
    }
}
