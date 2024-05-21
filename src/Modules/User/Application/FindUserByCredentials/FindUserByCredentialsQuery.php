<?php
declare(strict_types=1);

namespace App\Modules\User\Application\FindUserByCredentials;

use App\Modules\Shared\Domain\Query;

final readonly class FindUserByCredentialsQuery implements Query
{

    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['email'] ?? null,
            $data['password'] ?? null,
        );
    }
}