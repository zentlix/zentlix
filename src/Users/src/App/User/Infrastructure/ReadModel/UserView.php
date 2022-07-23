<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel;

use Assert\Assertion;
use Broadway\ReadModel\SerializableReadModel;
use Broadway\Serializer\Serializable;
use Doctrine\Common\Collections\Collection;
use OpenApi\Attributes as OA;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\LocaleView;
use Zentlix\Users\App\User\Domain\ResetToken;
use Zentlix\Users\App\User\Domain\Role;
use Zentlix\Users\App\User\Domain\Status;
use Zentlix\Users\App\User\Domain\UserGroup;
use Zentlix\Users\App\User\Domain\ValueObject\Email;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema(
    schema: 'UserView',
    description: 'User record',
    required: ['uuid', 'email', 'email_confirmed', 'status', 'reset_token', 'created_at', 'updated_at'],
    type: 'object',
)]
class UserView implements SerializableReadModel, UserInterface, PasswordAuthenticatedUserInterface
{
    public const TYPE = 'UserView';

    #[OA\Property(property: 'uuid', type: 'string', example: '7be33fd4-ff46-11ea-adc1-0242ac120002')]
    public Uuid $uuid;

    #[Ignore]
    public string $password;

    #[OA\Property(property: 'email', type: 'string', example: 'email@domain.com')]
    public Email $email;

    #[OA\Property(property: 'first_name', type: 'string')]
    public ?string $firstName = null;

    #[OA\Property(property: 'last_name', type: 'string')]
    public ?string $lastName = null;

    #[OA\Property(property: 'middle_name', type: 'string')]
    public ?string $middleName = null;

    #[OA\Property(property: 'email_confirmed', type: 'bool')]
    public bool $emailConfirmed;

    #[OA\Property(property: 'email_confirm_token', type: 'string')]
    public ?string $emailConfirmToken = null;

    #[Ignore]
    public Collection $groups;

    #[OA\Property(
        property: 'status',
        type: 'string',
        enum: ['active', 'blocked', 'wait']
    )]
    public Status $status;

    #[OA\Property(
        property: 'reset_token',
        properties: [
            new OA\Property(type: 'string', property: 'reset_token'),
            new OA\Property(type: 'datetime', property: 'reset_token_expires', format: 'c'),
        ],
        type: 'object'
    )]
    public ResetToken $resetToken;

    #[OA\Property(property: 'new_email', type: 'string', example: 'email@domain.com')]
    public ?Email $newEmail = null;

    #[OA\Property(property: 'new_email_token', type: 'string')]
    public ?string $newEmailToken = null;

    #[Ignore]
    public ?LocaleView $locale = null;

    #[OA\Property(property: 'last_login', type: 'datetime', format: 'c')]
    public ?\DateTimeImmutable $lastLogin = null;

    #[OA\Property(property: 'updated_at', type: 'datetime', format: 'c')]
    public \DateTimeImmutable $updatedAt;

    #[OA\Property(property: 'created_at', type: 'datetime', format: 'c')]
    public \DateTimeImmutable $createdAt;

    public static function fromSerializable(Serializable $event): self
    {
        return self::deserialize($event->serialize());
    }

    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'email');
        Assertion::keyExists($data, 'email_confirmed');
        Assertion::keyExists($data, 'status');
        Assertion::keyExists($data, 'reset_token');
        Assertion::keyExists($data, 'created_at');
        Assertion::keyExists($data, 'updated_at');

        $view = new self();

        $view->uuid = UuidV4::fromString($data['uuid']);
        $view->email = Email::fromString($data['email']);
        $view->password = $data['password'];
        $view->firstName = !empty($data['first_name']) ? $data['first_name'] : null;
        $view->lastName = !empty($data['last_name']) ? $data['last_name'] : null;
        $view->middleName = !empty($data['middle_name']) ? $data['middle_name'] : null;
        $view->emailConfirmed = (bool) $data['email_confirmed'];
        $view->emailConfirmToken = !empty($data['email_confirm_token']) ? $data['email_confirm_token'] : null;
        // TODO add groups
        $view->status = Status::from($data['status']);
        $view->locale = !empty($data['locale']) ? LocaleView::deserialize($data['locale']) : null;

        // TODO add carbon and check format
        /** @psalm-suppress PossiblyFalsePropertyAssignmentValue */
        $view->lastLogin = !empty($data['last_login']) ?
            \DateTimeImmutable::createFromFormat('c', $data['last_login']) :
            null;

        /** @psalm-suppress PossiblyFalsePropertyAssignmentValue */
        $view->updatedAt = \DateTimeImmutable::createFromFormat('c', $data['updated_at']);

        /** @psalm-suppress PossiblyFalsePropertyAssignmentValue */
        $view->createdAt = \DateTimeImmutable::createFromFormat('c', $data['created_at']);

        return $view;
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->getId(),
            'email' => $this->email->getValue(),
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'middle_name' => $this->middleName,
            'email_confirmed' => $this->emailConfirmed,
            'email_confirm_token' => $this->emailConfirmToken,
            'groups' => $this->groups,
            'status' => $this->status->value,
            'reset_token' => [
                'reset_token' => $this->resetToken->getToken(),
                'reset_token_expires' => $this->resetToken->getExpires()?->format('c'),
            ],
            'new_email' => $this->newEmail?->getValue(),
            'new_email_token' => $this->newEmailToken,
            'locale' => $this->locale,
            'last_login' => $this->lastLogin?->format('c'),
            'updated_at' => $this->updatedAt->format('c'),
            'created_at' => $this->createdAt->format('c'),
        ];
    }

    #[Ignore]
    public function getId(): string
    {
        return $this->uuid->toRfc4122();
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        $roles = [];
        /** @var UserGroup $group */
        foreach ($this->groups as $group) {
            $roles[] = $group->getRole()->value;
        }

        // guarantee every user at least has ROLE_USER
        $roles[] = Role::USER->value;

        return array_unique($roles);
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email->getValue();
    }
}
