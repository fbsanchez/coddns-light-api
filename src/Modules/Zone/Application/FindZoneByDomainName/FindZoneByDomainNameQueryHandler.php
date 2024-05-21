<?php
declare(strict_types=1);

namespace App\Modules\Zone\Application\FindZoneByDomainName;

use App\Modules\Shared\Domain\QueryHandler;
use App\Modules\Zone\Domain\Exception\ZoneNotFoundException;
use App\Modules\Zone\Domain\Message\ZoneResponse;
use App\Modules\Zone\Domain\ZoneRepository;

final class FindZoneByDomainNameQueryHandler implements QueryHandler
{
    public function __construct(
        private ZoneRepository $zoneRepository,
    )
    {
    }

    public function __invoke(FindZoneByDomainNameQuery $query): ZoneResponse
    {
        $zone = $this->zoneRepository->findByName($query->domainName);
        if (null === $zone) {
            throw new ZoneNotFoundException($query->domainName);
        }

        return $zone->toResponse();
    }

}