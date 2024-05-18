<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Model;

use App\Modules\Domain\Domain\Model\ValueObject\DomainNameValueObject;
use Safe\DateTime;

final class Domain
{
    public function __construct(
        private readonly int                   $id,
        private readonly int                   $userId,
        private readonly DomainNameValueObject $domainName,
        private readonly string                $ip,
        private readonly DateTime              $created,
        private readonly DateTime              $lastUpdated,
        private readonly int                   $groupId,
        private readonly int                   $registerTypeId,
        private readonly ?int                  $domainId,
        private readonly int                   $zoneId,
        private readonly int                   $ttl,
        private readonly string                $rtag,

    )
    {
    }

    public function toArray(): array
    {
        return [
            'id'           => $this->id(),
            'oid'          => $this->userId(),
            'tag'          => $this->domainName()->value(),
            'ip'           => $this->ip(),
            'created'      => $this->created()->format('Y-m-d H:i:s'),
            'last_updated' => $this->lastUpdated()->format('Y-m-d H:i:s'),
            'gid'          => $this->groupId(),
            'rtype'        => $this->registerTypeId(),
            'rid'          => $this->domainId(),
            'zone_id'      => $this->zoneId(),
            'ttl'          => $this->ttl(),
            'rtag'         => $this->rtag(),
        ];

    }

    public function id(): int
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function domainName(): DomainNameValueObject
    {
        return $this->domainName;
    }

    public function ip(): string
    {
        return $this->ip;
    }

    public function created(): DateTime
    {
        return $this->created;
    }

    public function lastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function groupId(): int
    {
        return $this->groupId;
    }

    public function registerTypeId(): int
    {
        return $this->registerTypeId;
    }

    public function domainId(): ?int
    {
        return $this->domainId;
    }

    public function zoneId(): int
    {
        return $this->zoneId;
    }

    public function ttl(): int
    {
        return $this->ttl;
    }

    public function rtag(): string
    {
        return $this->rtag;
    }


}