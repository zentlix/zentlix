<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain\Event;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Broadway\Serializer\Serializable;
use Symfony\Component\Uid\Uuid;

final class LocaleWasCreated implements Serializable
{
    public function __construct(
        public Uuid $uuid,

        /** @psalm-var non-empty-string */
        public string $title,

        /** @psalm-var non-empty-string */
        public string $code,

        /** @psalm-var non-empty-string */
        public string $countryCode,

        /** @psalm-var positive-int */
        public int $sort
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
        Assertion::keyExists($data, 'country_code');
        Assertion::keyExists($data, 'sort');

        Assertion::uuid($data['uuid']);
        Assertion::string($data['title']);
        Assertion::string($data['code']);
        Assertion::string($data['country_code']);
        Assertion::integer($data['sort']);

        return new self(
            Uuid::fromString($data['uuid']),
            $data['title'],
            $data['code'],
            $data['country_code'],
            $data['sort']
        );
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->uuid->toRfc4122(),
            'title' => $this->title,
            'code' => $this->code,
            'country_code' => $this->countryCode,
            'sort' => $this->sort,
        ];
    }
}
