<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints;
use Zentlix\Core\App\Shared\Application\Command\CreateCommandInterface;
use Zentlix\Users\App\User\Domain\Status;

final class CreateUserCommand extends UserCommand implements CreateCommandInterface
{
    /** @psalm-readonly */
    #[Constraints\Uuid]
    public readonly Uuid $uuid;

    #[Constraints\NotBlank]
    public string $plainPassword;

    public readonly bool $emailConfirmed;

    public readonly string $emailConfirmToken;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->status = Status::ACTIVE;
        $this->emailConfirmToken = Uuid::v4()->toRfc4122();
        $this->emailConfirmed = false;
        $this->updatedAt = new \DateTimeImmutable();
        $this->createdAt = new \DateTimeImmutable();
    }
}
