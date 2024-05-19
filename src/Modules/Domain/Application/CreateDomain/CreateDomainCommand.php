<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\CreateDomain;

use App\Shared\Domain\Message;

final class CreateDomainCommand implements Message
{
    public const OWNER_ID = 'owner_id';

    public function __construct(
        public string $domainName,
        public string $ip,
        public int $ownerId,
        public string $recordType,
        public ?string $cnameAs,
    )
    {
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['domainName'],
            $data['ip'],
            $data['owner_id'],
            $data['record_type'],
            $data['cname_as'] ?? null,
        );
    }
}