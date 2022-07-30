<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints;
use Zentlix\Users\App\User\Domain\Status;
use Zentlix\Users\App\User\Domain\ValueObject\Email;

class UserCommand
{
    #[Constraints\NotBlank]
    #[Constraints\Email]
    protected Email $email;

    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $middleName = null;
    protected Collection $groups;

    #[Constraints\NotBlank]
    public Status $status;

    protected ?Uuid $locale = null;

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = new Email($email);

        return $this;
    }

    public function getLocale(): ?Uuid
    {
        return $this->locale;
    }

    public function setLocale(string $locale = null): self
    {
        if (null !== $locale) {
            $this->locale = Uuid::fromString($locale);
        }

        return $this;
    }

    public function setGroups(array $groups): self
    {
        $this->groups = new ArrayCollection($groups);

        return $this;
    }

    public function getGroups(): Collection
    {
        return $this->groups;
    }
}
