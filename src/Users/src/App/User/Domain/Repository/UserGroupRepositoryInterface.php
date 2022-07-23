<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Repository;

use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Domain\UserGroup;

interface UserGroupRepositoryInterface
{
    public function get(Uuid $uuid): UserGroup;

    public function store(UserGroup $userGroup): void;
}
