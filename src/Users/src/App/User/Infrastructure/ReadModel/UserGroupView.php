<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Infrastructure\ReadModel\AbstractSerializableReadModel;
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
class UserGroupView extends AbstractSerializableReadModel
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

    #[Ignore]
    public function getId(): string
    {
        return $this->uuid->toRfc4122();
    }
}
