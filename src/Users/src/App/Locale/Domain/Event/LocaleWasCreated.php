<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain\Event;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Broadway\Serializer\Serializable;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\Locale\Application\Command\CreateCommand;

final class LocaleWasCreated implements Serializable
{
    public Uuid $uuid;

    /** @psalm-var non-empty-string */
    public string $title;

    /** @psalm-var non-empty-string */
    public string $code;

    /** @psalm-var non-empty-string */
    public string $countryCode;

    /** @psalm-var positive-int */
    public int $sort;

    public function __construct(CreateCommand $command)
    {
        $this->uuid = $command->uuid;
        $this->title = $command->title;
        $this->code = $command->code;
        $this->countryCode = $command->countryCode;
        $this->sort = $command->sort;
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

        $command = new CreateCommand();
        $command->uuid = Uuid::fromString($data['uuid']);
        $command->title = $data['title'];
        $command->code = $data['code'];
        $command->countryCode = $data['country_code'];
        $command->sort = $data['sort'];

        return new self($command);
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
