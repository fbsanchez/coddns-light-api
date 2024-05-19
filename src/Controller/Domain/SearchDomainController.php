<?php
declare(strict_types=1);

namespace App\Controller\Domain;

use App\Controller\Shared\QueryController;
use App\Modules\Domain\Application\SearchDomain\SearchDomainQuery;

final class SearchDomainController extends QueryController
{

    function query(): string
    {
        return SearchDomainQuery::class;
    }

    public function customParameters(array $parameters): array
    {
        return [ SearchDomainQuery::OWNER_ID => $this->getAuthUser()->id() ];
    }
}