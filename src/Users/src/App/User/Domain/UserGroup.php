<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Application\Command\CreateUserGroupCommand;
use Zentlix\Users\App\User\Domain\Event\UserGroupWasCreated;
use Zentlix\Users\App\User\Domain\Service\UserGroupValidatorInterface;

class UserGroup extends EventSourcedAggregateRoot
{
    private Uuid $uuid;

    /** @psalm-var non-empty-string */
    private string $title;

    /** @psalm-var non-empty-string */
    private string $code;

    /** @psalm-var positive-int */
    private int $sort;

    private Role $role;

    private array $rights = [];

    public function __construct(CreateUserGroupCommand $command, UserGroupValidatorInterface $validator)
    {
        $validator->preCreate($command);

        $this->apply(new UserGroupWasCreated(
            $command->uuid,
            $command->title,
            $command->code,
            $command->sort,
            $command->role,
            $command->rights
        ));
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /** @psalm-return non-empty-string */
    public function getTitle(): string
    {
        return $this->title;
    }

    /** @psalm-return non-empty-string */
    public function getCode(): string
    {
        return $this->code;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getRights(): array
    {
        return $this->rights;
    }

    /** @psalm-return positive-int */
    public function getSort(): int
    {
        return $this->sort;
    }

    /** @psalm-param non-empty-string $code */
    public function isCodeEqual(string $code): bool
    {
        return $code === $this->code;
    }

    public function isAdminGroup(): bool
    {
        return true; // TODO
    }

    public function isAccessGranted(): bool
    {
        return true; // TODO
    }

    public function getAggregateRootId(): string
    {
        return $this->uuid->toRfc4122();
    }

    protected function applyUserGroupWasCreated(UserGroupWasCreated $event): void
    {
        $this->uuid = $event->uuid;
        $this->title = $event->title;
        $this->code = $event->code;
        $this->role = $event->role;
        $this->sort = $event->sort;
        $this->rights = $event->rights;
    }
}
