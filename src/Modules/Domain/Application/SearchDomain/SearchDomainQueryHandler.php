<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\SearchDomain;

use App\Modules\Domain\Domain\DomainRepository;
use App\Shared\Domain\QueryHandler;

final readonly class SearchDomainQueryHandler implements QueryHandler
{
    public function __construct(
        private DomainRepository $repository,
    )
    {
    }

    public function __invoke(SearchDomainQuery $query): array
    {
        return $this->repository->searchByOwner($query->ownerId);
    }
}