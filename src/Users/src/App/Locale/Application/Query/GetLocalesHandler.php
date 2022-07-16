<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Application\Query;

use Assert\AssertionFailedException;
use Zentlix\Core\App\Shared\Application\Query\Collection;
use Zentlix\Core\App\Shared\Application\Query\Item;
use Zentlix\Core\App\Shared\Application\Query\QueryHandlerInterface;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Exception\NotFoundException;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\LocaleView;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\LocaleRepositoryInterface;

final class GetLocalesHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly LocaleRepositoryInterface $localeRepository
    ) {
    }

    /**
     * @throws AssertionFailedException
     * @throws NotFoundException
     */
    public function __invoke(GetLocalesQuery $query): Collection
    {
        $pagination = $this->localeRepository->page($query->page, $query->limit);

        return new Collection(
            $query->page,
            $query->limit,
            $pagination->getTotalItemCount(),
            array_map(fn (LocaleView $view) => Item::fromSerializable($view), (array) $pagination->getItems())
        );
    }
}
