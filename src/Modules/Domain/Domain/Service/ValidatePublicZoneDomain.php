<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Service;

use App\Modules\Shared\Domain\QueryBus;
use App\Modules\Shared\Domain\ValueObject\DomainNameValueObject;
use App\Modules\Zone\Application\FindZoneByDomainName\FindZoneByDomainNameQuery;
use App\Modules\Zone\Domain\Message\ZoneResponse;
use App\Modules\Zone\Domain\Model\Zone;

final class ValidatePublicZoneDomain
{
    public function __construct(
        private readonly QueryBus $queryBus,
    )
    {
    }

    public function __invoke(DomainNameValueObject $domainName): bool
    {
        $query = new FindZoneByDomainNameQuery($domainName->getBaseDomainName());

        /** @var ZoneResponse $zoneResponse */
        $zoneResponse = $this->queryBus->ask($query);

        if (null === $zoneResponse) {
            return false;
        }

        return Zone::fromResponse($zoneResponse)->isPublic();
    }

}