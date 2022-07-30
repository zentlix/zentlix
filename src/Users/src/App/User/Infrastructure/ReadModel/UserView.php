<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel;

use Doctrine\Common\Collections\Collection;
use OpenApi\Attributes as OA;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Infrastructure\ReadModel\AbstractSerializableReadModel;
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
class UserView extends AbstractSerializableReadModel implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const TYPE = 'UserView';

    #[OA\Property(property: 'uuid', type: 'string', example: '7be33fd4-ff46-11ea-adc1-0242ac120002')]
    public Uuid $uuid;

    #[Ignore]
    public string $password;

    #[OA\Property(property: 'email', type: 'string', example: 'email@domain.com')]
    public Email $email;

    #[SerializedName('first_name')]
    public ?string $firstName = null;

    #[SerializedName('last_name')]
    public ?string $lastName = null;

    #[SerializedName('middle_name')]
    public ?string $middleName = null;

    #[SerializedName('email_confirmed')]
    public bool $emailConfirmed;

    #[SerializedName('email_confirm_token')]
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

    #[SerializedName('new_email_token')]
    public ?string $newEmailToken = null;

    #[Ignore]
    public ?LocaleView $locale = null;

    #[SerializedName('last_login')]
    public ?\DateTimeImmutable $lastLogin = null;

    #[SerializedName('updated_at')]
    public \DateTimeImmutable $updatedAt;

    #[SerializedName('created_at')]
    public \DateTimeImmutable $createdAt;

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

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email->getValue();
    }
}
