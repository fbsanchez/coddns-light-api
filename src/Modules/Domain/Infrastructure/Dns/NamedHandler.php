<?php
declare(strict_types=1);

namespace App\Modules\Domain\Infrastructure\Dns;

use App\Modules\Domain\Domain\DnsHandler;
use App\Modules\Domain\Domain\Model\Domain;
use App\Modules\Domain\Domain\Model\ValueObject\RecordTypeId;

final class NamedHandler implements DnsHandler
{
    private const DEFAULT_MX_PRIORITY = "10";

    public function __construct(
        private string $domainManagementUtility,
    )
    {
    }

    public function add(Domain $domain): void
    {
        $this->validate(
            shell_exec(
                sprintf(
                    "%s a %s %s %s %d %s",
                    $this->domainManagementUtility,
                    $domain->domainName()->value(),
                    $domain->recordTypeId()->toString(),
                    $this->registerValue($domain),
                    $domain->ttl(),
                    RecordTypeId::MX === $domain->recordTypeId()->value() ? '' : self::DEFAULT_MX_PRIORITY,
                ),
            ),
        );

    }

    private function validate(?string $executionOutput): void
    {
        if (0 === \Safe\preg_match('/OK/', $executionOutput ?? '')) {
            throw new \RuntimeException($executionOutput ?? 'No response from domain management utility');
        }

    }

    private function registerValue(Domain $domain): string
    {
        return match ($domain->recordTypeId()->value()) {
            RecordTypeId::MX,
            RecordTypeId::CNAME => $domain->rtag(),
            default => $domain->ip()->value(),
        };
    }

    public function remove(Domain $domain): void
    {
        $this->validate(
            shell_exec(
                sprintf(
                    "%s d %s %s",
                    $this->domainManagementUtility,
                    $domain->recordTypeId()->toString(),
                    $domain->domainName()->value(),
                ),
            ),
        );
    }
}