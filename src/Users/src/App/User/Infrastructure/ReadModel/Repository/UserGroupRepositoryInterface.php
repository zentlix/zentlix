<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel\Repository;

use Zentlix\Users\App\User\Infrastructure\ReadModel\UserGroupView;

interface UserGroupRepositoryInterface
{
    public function add(UserGroupView $userGroupRead): void;

    public function findAll(array $orderBy = ['sort' => 'asc']): array;

    /**
     * @return UserGroupView[]
     */
    public function findByUuid(array $uuid, array $orderBy = ['sort' => 'asc']): array;
}
