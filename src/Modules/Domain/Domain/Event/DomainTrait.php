<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Event;

use App\Modules\Domain\Domain\Model\Domain;
use App\Modules\Domain\Domain\Model\ValueObject\Ip;
use App\Modules\Domain\Domain\Model\ValueObject\RecordTypeId;
use App\Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use App\Modules\Shared\Domain\ValueObject\DomainNameValueObject;

trait DomainTrait
{
    public function __construct(
        public readonly int     $id,
        public readonly int     $userId,
        public readonly string  $domainName,
        public readonly string  $ip,
        public readonly string  $created,
        public readonly string  $lastUpdated,
        public readonly int     $groupId,
        public readonly int     $recordTypeId,
        public readonly int     $zoneId,
        public readonly int     $ttl,
        public readonly ?string $rtag,
    )
    {
    }

    public static function fromDomain(Domain $domain): self
    {
        return new self(
            id: $domain->id(),
            userId: $domain->userId(),
            domainName: $domain->domainName()->value(),
            ip: $domain->ip()->value(),
            created: $domain->created()->toString(),
            lastUpdated: $domain->lastUpdated()->toString(),
            groupId: $domain->groupId(),
            recordTypeId: $domain->recordTypeId()->value(),
            zoneId: $domain->zoneId(),
            ttl: $domain->ttl(),
            rtag: $domain->rtag()?->value(),
        );
    }

    public function toDomain(): Domain
    {
        return new Domain(
            id: $this->id,
            userId: $this->userId,
            domainName: DomainNameValueObject::create($this->domainName),
            ip: Ip::create($this->ip),
            created: DateTimeValueObject::create($this->created),
            lastUpdated: DateTimeValueObject::create($this->lastUpdated),
            groupId: $this->groupId,
            recordTypeId: RecordTypeId::create($this->recordTypeId),
            zoneId: $this->zoneId,
            ttl: $this->ttl,
            rtag: DomainNameValueObject::createOrNull($this->rtag),
        );
    }

}