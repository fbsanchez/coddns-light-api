<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\SearchDomain;

use App\Shared\Domain\Query;

final class SearchDomainQuery implements Query
{
    public const OWNER_ID = 'owner_id';

    public function __construct(public int $ownerId)
    {
    }

    public static function fromPrimitives(array $data): self
    {
        return new self($data[self::OWNER_ID]);
    }

}