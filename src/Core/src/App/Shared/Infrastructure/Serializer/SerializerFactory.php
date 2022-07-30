<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Infrastructure\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @internal
 */
final class SerializerFactory
{
    public static function create(): Serializer
    {
        $factory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizers = [
            new Normalizer\UnwrappingDenormalizer(),
            new Normalizer\ProblemNormalizer(),
            new Normalizer\UidNormalizer(),
            new Normalizer\JsonSerializableNormalizer(),
            new Normalizer\DateTimeNormalizer(),
            new Normalizer\ConstraintViolationListNormalizer(),
            new Normalizer\DateTimeZoneNormalizer(),
            new Normalizer\DateIntervalNormalizer(),
            new Normalizer\BackedEnumNormalizer(),
            new Normalizer\DataUriNormalizer(),
            new Normalizer\ArrayDenormalizer(),
            new Normalizer\ObjectNormalizer(
                $factory,
                new MetadataAwareNameConverter($factory),
                PropertyAccess::createPropertyAccessor(),
                new ReflectionExtractor()
            ),
        ];

        return new Serializer($normalizers, [new JsonEncoder()]);
    }
}
