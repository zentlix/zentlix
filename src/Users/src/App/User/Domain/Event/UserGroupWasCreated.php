<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Event;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Broadway\Serializer\Serializable;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Domain\Role;

final class UserGroupWasCreated implements Serializable
{
    public function __construct(
        public Uuid $uuid,

        /** @psalm-var non-empty-string */
        public string $title,

        /** @psalm-var non-empty-string */
        public string $code,

        /** @psalm-var positive-int */
        public int $sort,

        public Role $role,

        public array $rights
    ) {
    }

    /**
     * @throws AssertionFailedException
     */
    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'title');
        Assertion::keyExists($data, 'code');
        Assertion::keyExists($data, 'sort');
        Assertion::keyExists($data, 'role');
        Assertion::keyExists($data, 'rights');

        Assertion::uuid($data['uuid']);
        Assertion::string($data['title']);
        Assertion::string($data['code']);
        Assertion::integer($data['sort']);
        Assertion::string($data['role']);
        Assertion::isArray($data['rights']);

        /** @psalm-suppress ArgumentTypeCoercion */
        return new self(
            Uuid::fromString($data['uuid']),
            $data['title'],
            $data['code'],
            $data['sort'],
            Role::from($data['role']),
            $data['rights']
        );
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->uuid->toRfc4122(),
            'title' => $this->title,
            'code' => $this->code,
            'sort' => $this->sort,
            'role' => $this->role->value,
            'rights' => $this->rights,
        ];
    }
}
