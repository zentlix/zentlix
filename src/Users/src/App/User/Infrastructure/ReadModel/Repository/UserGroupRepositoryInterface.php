<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel\Repository;

use Zentlix\Users\App\User\Infrastructure\ReadModel\UserGroupView;

interface UserGroupRepositoryInterface
{
    public function add(UserGroupView $userGroupRead): void;
}
