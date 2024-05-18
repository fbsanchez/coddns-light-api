<?php
declare(strict_types=1);

namespace App\Modules\User\Application\FindUserByCredentials;

use App\Shared\Domain\Message;

final readonly class FindUserByCredentialsQuery implements Message
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