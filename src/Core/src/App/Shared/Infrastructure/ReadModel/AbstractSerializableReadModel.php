<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Infrastructure\ReadModel;

use Broadway\ReadModel\SerializableReadModel;
use Broadway\Serializer\Serializable;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Zentlix\Core\App\Shared\Infrastructure\Serializer\SerializerFactory;

abstract class AbstractSerializableReadModel implements SerializableReadModel
{
    public static function deserialize(array $data): static
    {
        return SerializerFactory::create()->denormalize($data, static::class);
    }

    /**
     * @throws ExceptionInterface
     */
    public function serialize(): array
    {
        /** @var array $data */
        $data = SerializerFactory::create()->normalize($this);

        return $data;
    }

    public static function fromSerializable(Serializable $event): static
    {
        return static::deserialize($event->serialize());
    }
}
