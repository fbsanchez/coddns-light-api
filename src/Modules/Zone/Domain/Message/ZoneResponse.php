<?php
declare(strict_types=1);

namespace App\Modules\Zone\Domain\Message;

use App\Modules\Shared\Domain\QueryResponse;

final class ZoneResponse implements QueryResponse
{
    public function __construct(
        public readonly int    $id,
        public readonly string $domain,
        public readonly bool   $isPublic,
    )
    {
    }
}