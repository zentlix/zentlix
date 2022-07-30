<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Infrastructure\ReadModel;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Infrastructure\ReadModel\AbstractSerializableReadModel;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema(
    schema: 'LocaleView',
    description: 'Locale record',
    type: 'object',
    required: ['uuid', 'title', 'code', 'country_code', 'sort'],
)]
class LocaleView extends AbstractSerializableReadModel
{
    public const TYPE = 'LocaleView';

    #[OA\Property(type: 'string', property: 'uuid', example: '7be33fd4-ff46-11ea-adc1-0242ac120002')]
    public Uuid $uuid;

    /** @psalm-var non-empty-string */
    public string $title;

    /** @psalm-var non-empty-string */
    public string $code;

    /** @psalm-var non-empty-string */
    #[SerializedName('country_code')]
    public string $countryCode;

    /** @psalm-var positive-int */
    public int $sort;

    #[Ignore]
    public function getId(): string
    {
        return $this->uuid->toRfc4122();
    }
}
