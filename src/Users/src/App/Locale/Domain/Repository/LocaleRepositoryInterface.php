<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain\Repository;

use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\Locale\Domain\Locale;

interface LocaleRepositoryInterface
{
    public function get(Uuid $uuid): Locale;

    public function store(Locale $locale): void;
}
