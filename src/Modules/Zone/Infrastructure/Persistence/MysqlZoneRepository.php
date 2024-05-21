<?php
declare(strict_types=1);

namespace App\Modules\Zone\Infrastructure\Persistence;

use App\Modules\Shared\Infrastructure\Persistence\MysqlClient;
use App\Modules\Zone\Domain\Model\Zone;
use App\Modules\Zone\Domain\ZoneRepository;

final class MysqlZoneRepository implements ZoneRepository
{
    private const TABLE = "zones";

    public function __construct(
        private readonly MysqlClient $mysqlClient,
    )
    {
    }

    public function findByName(string $name): ?Zone
    {
        $sql = sprintf('SELECT * FROM `%s` WHERE `domain` = "%s"',
            self::TABLE,
            $this->mysqlClient->escape($name),
        );

        $result = $this->mysqlClient->get($sql);

        if (null === $result) {
            return null;
        }

        return Zone::fromArray($result);
    }
}