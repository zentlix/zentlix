<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel;

use Assert\Assertion;
use Broadway\ReadModel\SerializableReadModel;
use Broadway\Serializer\Serializable;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;
use Zentlix\Users\App\User\Domain\Role;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema(
    schema: 'UserGroupView',
    description: 'User group record',
    required: ['uuid', 'title', 'code', 'sort', 'role', 'rights'],
    type: 'object',
)]
class UserGroupView implements SerializableReadModel
{
    public const TYPE = 'UserGroupView';

    #[OA\Property(property: 'uuid', type: 'string', example: '7be33fd4-ff46-11ea-adc1-0242ac120002')]
    public Uuid $uuid;

    /** @psalm-var non-empty-string */
    public string $title;

    /** @psalm-var non-empty-string */
    public string $code;

    /** @psalm-var positive-int */
    public int $sort;

    #[OA\Property(
        property: 'role',
        type: 'string',
        enum: ['ROLE_USER', 'ROLE_ADMIN']
    )]
    public Role $role;

    public array $rights = [];

    public static function fromSerializable(Serializable $event): self
    {
        return self::deserialize($event->serialize());
    }

    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'title');
        Assertion::keyExists($data, 'code');
        Assertion::keyExists($data, 'sort');
        Assertion::keyExists($data, 'role');
        Assertion::keyExists($data, 'rights');

        $view = new self();

        $view->uuid = UuidV4::fromString($data['uuid']);
        $view->title = $data['title'];
        $view->code = $data['code'];
        /** @psalm-suppress PropertyTypeCoercion sort */
        $view->sort = (int) $data['sort'];
        $view->role = Role::from($data['role']);
        $view->rights = $data['rights'];

        return $view;
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->getId(),
            'title' => $this->title,
            'code' => $this->code,
            'sort' => $this->sort,
            'role' => $this->role->value,
            'rights' => $this->rights,
        ];
    }

    #[Ignore]
    public function getId(): string
    {
        return $this->uuid->toRfc4122();
    }
}
