<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\Locale\Domain\Locale;
use Zentlix\Users\App\User\Application\Command\CreateUserCommand;
use Zentlix\Users\App\User\Application\Command\UpdateUserCommand;
use Zentlix\Users\App\User\Domain\ValueObject\Email;

class User
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
    private ?Locale $locale = null;
    private ?\DateTimeInterface $lastLogin = null;
    private \DateTimeInterface $updatedAt;
    private \DateTimeInterface $createdAt;

    public function __construct(CreateUserCommand $command)
    {
        $this->uuid = $command->uuid;
        $this->emailConfirmToken = $command->emailConfirmToken;
        $this->emailConfirmed = $command->emailConfirmed;
        $this->resetToken = new ResetToken();

        $this->setValuesFromCommand($command);
    }

    public function update(UpdateUserCommand $command): void
    {
        $this->setValuesFromCommand($command);
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

    public function getLocale(): ?Locale
    {
        return $this->locale;
    }

    public function getRoles(): array
    {
        $roles = [];
        /** @var UserGroup $group */
        foreach ($this->groups->getValues() as $group) {
            $roles[] = $group->getRole()->value;
        }

        // guarantee every user at least has ROLE_USER
        $roles[] = Role::USER->value;

        return array_unique($roles);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function isAdminRole(): bool
    {
        return \in_array(Role::ADMIN, $this->getRoles());
    }

    public function isAdminGroup(): bool
    {
        /** @var UserGroup $group */
        foreach ($this->groups->getValues() as $group) {
            if ($group->isAdminGroup()) {
                return true;
            }
        }

        return false;
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

    public function isAccessGranted(string $command): bool
    {
        if (!$this->isAdminRole() || !$this->isActive()) {
            return false;
        }

        /** @var UserGroup $group $group */
        foreach ($this->groups->getValues() as $group) {
            if ($group->isAccessGranted()) {
                return true;
            }
        }

        return false;
    }

    private function setValuesFromCommand(CreateUserCommand|UpdateUserCommand $command): void
    {
        $this->email = $command->getEmail();
        $this->status = $command->status;
        $this->firstName = $command->firstName;
        $this->lastName = $command->lastName;
        $this->middleName = $command->middleName;
        $this->createdAt = $command->createdAt;
        $this->updatedAt = $command->updatedAt;
        $this->groups = new ArrayCollection($command->groups);
    }
}
