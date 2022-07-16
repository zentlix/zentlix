<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Application\Query;

use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Exception\NotFoundException;

class Collection
{
    /**
     * @param Item[]|array $data
     *
     * @throws NotFoundException
     */
    public function __construct(
        public readonly int $page,
        public readonly int $limit,
        public readonly int $total,
        public readonly array $data
    ) {
        $this->exists($page, $limit, $total);
    }

    /**
     * @throws NotFoundException
     */
    private function exists(int $page, int $limit, int $total): void
    {
        if (($limit * ($page - 1)) >= $total) {
            throw new NotFoundException();
        }
    }
}
