<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain;

use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Application\Command\CreateGroupCommand;
use Zentlix\Users\App\User\Application\Command\UpdateGroupCommand;

class UserGroup
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

    public function __construct(CreateGroupCommand $command)
    {
        $this->uuid = $command->uuid;

        $this->setValuesFromCommands($command);
    }

    public function update(UpdateGroupCommand $command): void
    {
        $this->setValuesFromCommands($command);
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

    private function setValuesFromCommands(CreateGroupCommand|UpdateGroupCommand $command): void
    {
        $this->title = $command->title;
        $this->code = $command->code;
        $this->role = $command->role;
        $this->sort = $command->sort;
        $this->rights = $command->rights;
    }
}
