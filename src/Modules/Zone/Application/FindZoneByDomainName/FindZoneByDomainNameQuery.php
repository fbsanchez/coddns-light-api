<?php
declare(strict_types=1);

namespace App\Modules\Zone\Application\FindZoneByDomainName;

use App\Modules\Shared\Domain\Query;

final class FindZoneByDomainNameQuery implements Query
{
    public function __construct(
        public string $domainName,
    )
    {
    }

}