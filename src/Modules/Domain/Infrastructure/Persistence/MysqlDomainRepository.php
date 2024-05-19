<?php
declare(strict_types=1);

namespace App\Modules\Domain\Infrastructure\Persistence;

use App\Modules\Domain\Domain\DomainRepository;
use App\Modules\Domain\Domain\Model\Domain;
use App\Shared\Infrastructure\Persistence\MysqlClient;
use RuntimeException;

final class MysqlDomainRepository implements DomainRepository
{
    private const TABLE = 'hosts';

    public function __construct(
        private readonly MysqlClient $mysqlClient,
    )
    {
    }

    public function add(Domain $domain): void
    {
        $data = $domain->toArray();

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            self::TABLE,
            join(',', array_keys($data)),
            join(',',
                array_fill(0, count(array_keys($data)), '?'),
            ),
        );

        if (false === $this->mysqlClient->set($sql, $data)) {
            throw new RuntimeException();
        }
    }

    public function find(): Domain
    {
        // TODO: Implement find() method.
    }

    public function findByNameAndUserId(string $fullDomainName, int $userId): ?Domain
    {
        // TODO: Implement findByNameAndUserId() method.
    }

    public function remove(Domain $domain): void
    {
        // TODO: Implement remove() method.
    }

    public function searchByOwner(int $ownerId): array
    {
        $sql = sprintf(
            'SELECT * FROM hosts WHERE oid = %d',
            $ownerId,
        );
        $domains = $this->mysqlClient->getAll($sql);

        return array_map(
            static fn ($hostData) => Domain::fromArray($hostData),
            $domains,
        );
    }
}