<?php
declare(strict_types=1);

namespace App\Modules\User\Domain\Service;

final class HashPassword
{
    private const HASH_ALGORITHM = 'sha512';

    public function __invoke(string $password): string
    {
        return hash(self::HASH_ALGORITHM, $password);
    }

}