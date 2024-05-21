<?php
declare(strict_types=1);

namespace App\Modules\Shared\Infrastructure\Persistence;

use App\Modules\Shared\Domain\TransactionalPersistenceClient;

final class MysqlClient implements TransactionalPersistenceClient
{
    private \mysqli $pdo;

    public function __construct(
        ?string $host,
        ?int    $port,
        ?string $database,
        ?string $username,
        ?string $password,
        ?string $charset,
    )
    {
        $this->pdo = new \mysqli();
        $this->pdo->connect(
            hostname: $host,
            username: $username,
            password: $password,
            database: $database,
            port: $port,
        );

        $this->pdo->set_charset($charset);
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function escape(string $string): string
    {
        return $this->pdo->real_escape_string($string);
    }

    public function get(string $sql): ?array
    {
        $queryResult = $this->pdo->query($sql);

        $result = $queryResult->fetch_assoc();
        if (false === $result || null === $result) {
            return null;
        }

        return $result;
    }

    public function getAll(string $sql): array
    {
        return $this->pdo->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function rollback(): bool
    {
        return $this->pdo->rollback();
    }

    public function set(string $sql, ...$values): bool
    {
        $statement = $this->pdo->prepare($sql);
        return $statement->execute($values);
    }

    public function startTransaction(): bool
    {
        return $this->pdo->begin_transaction();
    }

}