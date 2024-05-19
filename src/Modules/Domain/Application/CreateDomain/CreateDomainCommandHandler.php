<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\CreateDomain;

use App\Modules\Domain\Domain\DomainRepository;
use App\Modules\Domain\Domain\Model\Domain;
use App\Modules\Domain\Domain\Model\ValueObject\DomainNameValueObject;
use App\Modules\Domain\Domain\Model\ValueObject\Ip;
use App\Modules\Domain\Domain\Model\ValueObject\RecordTypeId;
use App\Modules\Domain\Domain\Service\AssertCnameRecordTypeHasReference;
use App\Shared\Domain\ValueObject\Group;
use Safe\DateTime;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateDomainCommandHandler
{
    private AssertCnameRecordTypeHasReference $assertCnameRecordTypeHasReference;

    public function __construct(
        private DomainRepository $repository,
    )
    {
        $this->assertCnameRecordTypeHasReference = new AssertCnameRecordTypeHasReference();
    }

    public function __invoke(CreateDomainCommand $command): void
    {
        $recordTypeId = RecordTypeId::map($command->recordType);

        $this->assertCnameRecordTypeHasReference->__invoke($recordTypeId, $command->cnameAs);

        $this->repository->add(new Domain(
            id: 0, // Not really used.
            userId: $command->ownerId,
            domainName: DomainNameValueObject::create($command->domainName),
            ip: Ip::createOrNull($command->ip),
            created: new DateTime(),
            lastUpdated: new DateTime(),
            groupId: Group::PRIVATE,
            recordTypeId: $recordTypeId,
            zoneId: 1,
            ttl: 12,
            rtag: $command->cnameAs,
        ));
    }
}