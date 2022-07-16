<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Application\Query;

use Zentlix\Core\App\Shared\Application\Query\QueryInterface;

final class GetLocalesQuery implements QueryInterface
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $limit = 25
    ) {
    }
}
