<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\DeleteDomain;

use App\Modules\Shared\Domain\Message;

final readonly class DeleteDomainByDomainNameCommand implements Message
{
    public const OWNER_ID = 'owner_id';

    public function __construct(
        public string $domainName,
        public int    $ownerId,
    )
    {
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['domain'] ?? null,
            $data['owner_id'] ?? null,
        );
    }
}