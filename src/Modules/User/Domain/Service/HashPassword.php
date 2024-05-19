<?php
declare(strict_types=1);

namespace App\Modules\User\Domain\Service;

final readonly class HashPassword
{
    private const HASH_ALGORITHM = 'sha512';

    public function __construct(private string $salt)
    {
    }

    public function __invoke(string $password): string
    {
        return hash(self::HASH_ALGORITHM, $this->salt.$password);
    }

}