<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Repository;

use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Domain\User;

interface UserRepositoryInterface
{
    public function get(Uuid $uuid): User;

    public function store(User $user): void;
}
