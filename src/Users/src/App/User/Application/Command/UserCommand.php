<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Symfony\Component\Validator\Constraints;
use Zentlix\Users\App\Locale\Domain\Locale;
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
    public array $groups = [];

    #[Constraints\NotBlank]
    public Status $status;

    public Locale|string|null $locale = null;
    public \DateTimeInterface $updatedAt;
    public \DateTimeInterface $createdAt;

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = new Email($email);

        return $this;
    }
}
