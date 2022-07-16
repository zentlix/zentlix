<?php

declare(strict_types=1);

namespace Zentlix\Users\UI\Http\Rest\Controller;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Throwable;
use Zentlix\Core\App\Shared\Application\Query\Collection;
use Zentlix\Core\UI\Http\Rest\Controller\QueryController;
use Zentlix\Core\UI\Http\Rest\Response\OpenApi;
use Zentlix\Users\App\Locale\Application\Query\GetLocalesQuery;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\LocaleView;

class LocaleController extends QueryController
{
    /**
     * @throws AssertionFailedException
     * @throws Throwable
     */
    #[OA\Response(
        response: 200,
        description: 'Retrieve a collection of locales',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'meta',
                    ref: '#/components/schemas/ResponseCollectionMeta'
                ),
                new OA\Property(
                    property: 'data',
                    type: 'array',
                    description: 'Locale collection',
                    items: new OA\Items(ref: new Model(type: LocaleView::class))
                ),
                new OA\Property(
                    property: 'relationships',
                    ref: '#/components/schemas/Relationships'
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Bad request',
        content: new OA\JsonContent(ref: '#/components/schemas/Error')
    )]
    #[OA\Parameter(ref: '#/components/parameters/page')]
    #[OA\Parameter(ref: '#/components/parameters/limit')]
    #[OA\Parameter(
        name: 'sort',
        in: 'query',
        description: 'The field used to order locales',
        schema: new OA\Schema(type: 'string'),
        examples: [
            'locale.title' => new OA\Examples(
                example: 'locale.title',
                value: 'locale.title',
                summary: 'Sort by `locale.title` field'
            ),
            'locale.sort' => new OA\Examples(
                example: 'locale.sort',
                value: 'locale.sort',
                summary: 'Sort by `locale.sort` field'
            ),
            'locale.code' => new OA\Examples(
                example: 'locale.code',
                value: 'locale.code',
                summary: 'Sort by `locale.code` field'
            ),
            'locale.countryCode' => new OA\Examples(
                example: 'locale.countryCode',
                value: 'locale.countryCode',
                summary: 'Sort by `locale.country_code` field'
            ),
        ]
    )]
    #[OA\Parameter(ref: '#/components/parameters/direction')]
    #[OA\Tag(name: 'Locale')]
    #[Security(name: 'Bearer')]
    public function list(Request $request): OpenApi
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 25);
        $sort = $request->query->get('sort', 'sort');
        $direction = $request->query->get('direction', 'asc');

        Assertion::numeric($page, 'Page number must be an integer');
        Assertion::numeric($limit, 'Limit results must be an integer');
        Assertion::lessOrEqualThan($limit, 300, 'Limit results must be less or equal to 300');
        Assertion::inArray(
            $sort,
            ['locale.title', 'locale.sort', 'locale.code', 'locale.countryCode'],
            'Sort must be one of `locale.title`, `locale.sort`, `locale.code`, `locale.countryCode`'
        );
        Assertion::inArray($direction, ['asc', 'desc'], 'Direction must be one of `asc`, `desc`');

        /** @var Collection $response */
        $response = $this->ask(new GetLocalesQuery((int) $page, (int) $limit));

        return $this->jsonCollection($response, 200, true);
    }
}
