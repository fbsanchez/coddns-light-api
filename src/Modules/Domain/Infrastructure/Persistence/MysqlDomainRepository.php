<?php
declare(strict_types=1);

namespace App\Modules\Domain\Infrastructure\Persistence;

use App\Modules\Domain\Domain\DomainRepository;
use App\Modules\Domain\Domain\Model\Domain;
use App\Modules\Shared\Infrastructure\Persistence\MysqlClient;
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

        $fields = array_keys($data);
        $values = array_values($data);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            self::TABLE,
            join(',', $fields),
            join(',',
                array_fill(0, count($fields), '?'),
            ),
        );

        if (false === $this->mysqlClient->set($sql, ...$values)) {
            throw new RuntimeException();
        }
    }

    public function findByName(string $fullDomainName): ?Domain
    {
        $sql = sprintf('SELECT * FROM %s WHERE tag = "%s"',
            self::TABLE,
            $this->mysqlClient->escape($fullDomainName),
        );
        $result = $this->mysqlClient->get($sql);
        if (null === $result) {
            return null;
        }

        return Domain::fromArray($result);
    }

    public function findByNameAndUserId(string $fullDomainName, int $userId): ?Domain
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE `tag` = "%s" and `oid`=%d',
            self::TABLE,
            $this->mysqlClient->escape($fullDomainName),
            $userId,
        );

        $result = $this->mysqlClient->get($sql);
        if (null === $result) {
            return null;
        }

        return Domain::fromArray($result);
    }

    public function remove(Domain $domain): void
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE `tag` = ? AND `oid`= ?',
            self::TABLE,
        );

        $this->mysqlClient->set(
            $sql,
            $this->mysqlClient->escape($domain->domainName()->value()),
            $domain->userId(),
        );
    }

    public function searchByOwner(int $ownerId): array
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE oid = %d',
            self::TABLE,
            $ownerId,
        );
        $domains = $this->mysqlClient->getAll($sql);

        return array_map(
            static fn($hostData) => Domain::fromArray($hostData),
            $domains,
        );
    }
}