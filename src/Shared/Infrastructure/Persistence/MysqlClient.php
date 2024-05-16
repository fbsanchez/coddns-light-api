<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence;

final class MysqlClient
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

    public function get(string $sql): iterable
    {
        $queryResult = $this->pdo->query($sql);

        yield $queryResult->fetch_assoc();

    }

    public function getAll(string $sql): array
    {
        return $this->pdo->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function set(string $sql, array $values): bool
    {
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array_values($values));
    }

    public function startTransaction(): bool
    {
        return $this->pdo->begin_transaction();
    }

}