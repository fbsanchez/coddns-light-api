<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\CreateDomain;

use App\Modules\Domain\Domain\DomainRepository;
use App\Modules\Domain\Domain\Event\DomainCreated;
use App\Modules\Domain\Domain\Model\Domain;
use App\Modules\Domain\Domain\Model\ValueObject\Ip;
use App\Modules\Domain\Domain\Model\ValueObject\RecordTypeId;
use App\Modules\Domain\Domain\Service\AssertCnameRecordTypeHasReference;
use App\Modules\Domain\Domain\Service\AssertDomainNameDoesNotExist;
use App\Modules\Domain\Domain\Service\ValidatePublicZoneDomain;
use App\Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use App\Modules\Shared\Domain\ValueObject\DomainNameValueObject;
use App\Modules\Shared\Domain\ValueObject\Group;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class CreateDomainCommandHandler
{
    private AssertCnameRecordTypeHasReference $assertCnameRecordTypeHasReference;
    private AssertDomainNameDoesNotExist $assertDomainNameDoesNotExist;

    public function __construct(
        private MessageBusInterface      $messageBus,
        private DomainRepository         $repository,
        private ValidatePublicZoneDomain $validatePublicZoneDomain,
    )
    {
        $this->assertCnameRecordTypeHasReference = new AssertCnameRecordTypeHasReference();
        $this->assertDomainNameDoesNotExist = new AssertDomainNameDoesNotExist($this->repository);
    }

    public function __invoke(CreateDomainCommand $command): void
    {
        $recordTypeId = RecordTypeId::map($command->recordType);
        $domainName = DomainNameValueObject::create($command->domainName);

        $this->assertCnameRecordTypeHasReference->__invoke($recordTypeId, $command->cnameAs);
        $this->validatePublicZoneDomain->__invoke($domainName);
        $this->assertDomainNameDoesNotExist->__invoke($domainName);

        $domain = new Domain(
            id: 0, // Not really used.
            userId: $command->ownerId,
            domainName: $domainName,
            ip: Ip::createOrNull($command->ip),
            created: new DateTimeValueObject(),
            lastUpdated: new DateTimeValueObject(),
            groupId: Group::PRIVATE,
            recordTypeId: RecordTypeId::create($recordTypeId),
            zoneId: 1,
            ttl: $command->ttl,
            rtag: $command->cnameAs,
        );

        $this->repository->add($domain);
        $this->messageBus->dispatch(DomainCreated::fromDomain($domain));
    }
}