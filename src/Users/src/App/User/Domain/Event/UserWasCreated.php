<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Event;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Domain\Event\AbstractSerializableEvent;
use Zentlix\Users\App\User\Domain\Status;
use Zentlix\Users\App\User\Domain\ValueObject\Email;

final class UserWasCreated extends AbstractSerializableEvent
{
    public function __construct(
        public Uuid $uuid,
        public Email $email,
        public string $password,
        public Collection $groups,
        public Status $status,

        #[SerializedName('email_confirmed')]
        public bool $emailConfirmed,

        #[SerializedName('created_at')]
        public \DateTimeInterface $createdAt,

        #[SerializedName('updated_at')]
        public \DateTimeInterface $updatedAt,

        #[SerializedName('first_name')]
        public ?string $firstName = null,

        #[SerializedName('last_name')]
        public ?string $lastName = null,

        #[SerializedName('middle_name')]
        public ?string $middleName = null,

        public ?Uuid $locale = null,

        #[SerializedName('email_confirm_token')]
        public ?string $emailConfirmToken = null
    ) {
    }
}
