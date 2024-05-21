<?php
declare(strict_types=1);

namespace App\Modules\Shared\Domain;

interface TransactionalPersistenceClient
{
    public function commit(): bool;

    public function startTransaction(): bool;

    public function rollback(): bool;
}