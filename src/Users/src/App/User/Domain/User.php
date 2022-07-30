<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Application\Command\CreateUserCommand;
use Zentlix\Users\App\User\Domain\Event\UserWasCreated;
use Zentlix\Users\App\User\Domain\Service\UserValidatorInterface;
use Zentlix\Users\App\User\Domain\ValueObject\Email;

class User extends EventSourcedAggregateRoot
{
    private Uuid $uuid;
    private Email $email;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $middleName = null;
    private bool $emailConfirmed = false;
    private ?string $emailConfirmToken = null;
    private Collection $groups;
    private Status $status;
    private string $password;
    private ResetToken $resetToken;
    private ?Email $newEmail = null;
    private ?string $newEmailToken = null;
    private ?Uuid $locale = null;
    private ?\DateTimeInterface $lastLogin = null;
    private \DateTimeInterface $updatedAt;
    private \DateTimeInterface $createdAt;

    public function __construct(CreateUserCommand $command, UserValidatorInterface $validator)
    {
        $validator->preCreate($command);

        $this->apply(new UserWasCreated(
            $command->uuid,
            $command->getEmail(),
            $command->password,
            $command->getGroups(),
            $command->status,
            $command->emailConfirmed,
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            $command->firstName,
            $command->lastName,
            $command->middleName,
            $command->getLocale(),
            $command->emailConfirmToken
        ));
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getUsername(): string
    {
        return $this->email->getValue();
    }

    public function getLocale(): ?Uuid
    {
        return $this->locale;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function confirmEmail(): self
    {
        $this->emailConfirmed = true;
        $this->emailConfirmToken = null;

        return $this;
    }

    public function isEmailConfirmed(): bool
    {
        return $this->emailConfirmed;
    }

    public function isBlocked(): bool
    {
        return Status::BLOCKED === $this->status;
    }

    public function isActive(): bool
    {
        return Status::ACTIVE === $this->status;
    }

    public function isWait(): bool
    {
        return Status::WAIT === $this->status;
    }

    public function getAggregateRootId(): string
    {
        return $this->uuid->toRfc4122();
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->uuid = $event->uuid;
        $this->email = $event->email;
        $this->firstName = $event->firstName;
        $this->lastName = $event->lastName;
        $this->middleName = $event->middleName;
        $this->groups = $event->groups;
        $this->status = $event->status;
        $this->password = $event->password;
        $this->locale = $event->locale;
        $this->createdAt = $event->createdAt;
        $this->updatedAt = $event->updatedAt;
        $this->emailConfirmed = $event->emailConfirmed;
        $this->emailConfirmToken = $event->emailConfirmToken;
    }
}
