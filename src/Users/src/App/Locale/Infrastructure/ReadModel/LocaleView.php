<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Infrastructure\ReadModel;

use Assert\Assertion;
use Broadway\ReadModel\SerializableReadModel;
use Broadway\Serializer\Serializable;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema(
    schema: 'LocaleView',
    description: 'Locale record',
    type: 'object',
    required: ['uuid', 'title', 'code', 'country_code', 'sort'],
)]
class LocaleView implements SerializableReadModel
{
    public const TYPE = 'LocaleView';

    #[OA\Property(type: 'string', property: 'uuid', example: '7be33fd4-ff46-11ea-adc1-0242ac120002')]
    public Uuid $uuid;

    /** @psalm-var non-empty-string */
    public string $title;

    /** @psalm-var non-empty-string */
    public string $code;

    /** @psalm-var non-empty-string */
    #[OA\Property(type: 'string', property: 'country_code')]
    public string $countryCode;

    /** @psalm-var positive-int */
    public int $sort;

    public static function fromSerializable(Serializable $event): self
    {
        return self::deserialize($event->serialize());
    }

    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'title');
        Assertion::keyExists($data, 'code');
        Assertion::keyExists($data, 'country_code');
        Assertion::keyExists($data, 'sort');

        $view = new self();

        $view->uuid = UuidV4::fromString($data['uuid']);
        $view->title = $data['title'];
        $view->code = $data['code'];
        $view->countryCode = $data['country_code'];
        /** @psalm-suppress PropertyTypeCoercion sort */
        $view->sort = (int) $data['sort'];

        return $view;
    }

    public function serialize(): array
    {
        return [
            'uuid' => $this->getId(),
            'title' => $this->title,
            'code' => $this->code,
            'country_code' => $this->countryCode,
            'sort' => $this->sort,
        ];
    }

    #[Ignore]
    public function getId(): string
    {
        return $this->uuid->toRfc4122();
    }
}
