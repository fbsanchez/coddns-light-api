<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Model;

use App\Modules\Domain\Domain\Model\ValueObject\Ip;
use App\Modules\Domain\Domain\Model\ValueObject\RecordTypeId;
use App\Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use App\Modules\Shared\Domain\ValueObject\DomainNameValueObject;

final class Domain implements \JsonSerializable
{
    public function __construct(
        private readonly int                   $id,
        private readonly int                   $userId,
        private readonly DomainNameValueObject $domainName,
        private readonly ?Ip                   $ip,
        private readonly DateTimeValueObject   $created,
        private readonly DateTimeValueObject   $lastUpdated,
        private readonly int                   $groupId,
        private readonly RecordTypeId          $recordTypeId,
        private readonly int                   $zoneId,
        private readonly int                   $ttl,
        private readonly ?string               $rtag,

    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: null === $data['id'] ? null : (int)$data['id'],
            userId: null === $data['oid'] ? null : (int)$data['oid'],
            domainName: DomainNameValueObject::create($data['tag'] ?? null),
            ip: null === $data['ip'] ? null : Ip::fromLong((int)$data['ip']),
            created: DateTimeValueObject::create($data['created'] ?? null),
            lastUpdated: DateTimeValueObject::create($data['last_updated'] ?? null),
            groupId: null === $data['gid'] ? null : (int)$data['gid'],
            recordTypeId: RecordTypeId::create((int)$data['rtype']),
            zoneId: null === $data['zone_id'] ? null : (int)$data['zone_id'],
            ttl: null === $data['ttl'] ? null : (int)$data['ttl'],
            rtag: $data['rtag'] ?? null,
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id'           => $this->id(),
            'oid'          => $this->userId(),
            'tag'          => $this->domainName()->value(),
            'ip'           => $this->ip()?->value(),
            'created'      => $this->created()->toString(),
            'last_updated' => $this->lastUpdated()->toString(),
            'gid'          => $this->groupId(),
            'rtype'        => $this->recordTypeId()->value(),
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

    public function ip(): ?Ip
    {
        return $this->ip;
    }

    public function created(): DateTimeValueObject
    {
        return $this->created;
    }

    public function lastUpdated(): DateTimeValueObject
    {
        return $this->lastUpdated;
    }

    public function groupId(): int
    {
        return $this->groupId;
    }

    public function recordTypeId(): RecordTypeId
    {
        return $this->recordTypeId;
    }

    public function zoneId(): int
    {
        return $this->zoneId;
    }

    public function ttl(): int
    {
        return $this->ttl;
    }

    public function rtag(): ?string
    {
        return $this->rtag;
    }
}