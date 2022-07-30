<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Domain\Event;

use Broadway\Serializer\Serializable;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Zentlix\Core\App\Shared\Infrastructure\Serializer\SerializerFactory;

abstract class AbstractSerializableEvent implements Serializable
{
    /**
     * @throws ExceptionInterface
     */
    public static function deserialize(array $data): static
    {
        return SerializerFactory::create()->denormalize($data, static::class);
    }

    public function serialize(): array
    {
        /** @var array $data */
        $data = SerializerFactory::create()->normalize($this);

        return $data;
    }
}
