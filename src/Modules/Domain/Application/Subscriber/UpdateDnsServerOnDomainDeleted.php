<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\Subscriber;

use App\Modules\Domain\Domain\DnsHandler;
use App\Modules\Domain\Domain\Event\DomainDeleted;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateDnsServerOnDomainDeleted
{
    public function __construct(
        private readonly DnsHandler $dnsHandler,
    )
    {
    }

    public function __invoke(DomainDeleted $event): void
    {
        $this->dnsHandler->remove($event->toDomain());
    }

}