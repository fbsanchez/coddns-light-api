<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\CreateDomain;

use App\Modules\Shared\Domain\Message;

final readonly class CreateDomainCommand implements Message
{
    public const OWNER_ID = 'owner_id';
    private const MIN_TTL = 12;

    public function __construct(
        public string  $domainName,
        public string  $ip,
        public int     $ownerId,
        public string  $recordType,
        public ?string $cnameAs,
        public int     $ttl,
    )
    {
    }

    public static function fromPrimitives(array $data): self
    {
        $ttl = $data['ttl'] ?? self::MIN_TTL;

        return new self(
            $data['domain'],
            $data['ip'] ?? $_SERVER['REMOTE_ADDR'],
            $data['owner_id'],
            $data['type'],
            $data['cname_as'] ?? null,
            max($ttl, self::MIN_TTL),
        );
    }
}