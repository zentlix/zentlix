<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Repository;

use Symfony\Component\Uid\Uuid;

interface CheckUserGroupInterface
{
    /**
     * @param Uuid|Uuid[] $uuid
     *
     * @psalm-return ($uuid is array ? array : ?Uuid)
     */
    public function exists(array|Uuid $uuid): Uuid|array|null;
}
