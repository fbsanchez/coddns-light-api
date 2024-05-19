<?php
declare(strict_types=1);

namespace App\Modules\User\Domain\Message;

use App\Shared\Domain\QueryResponse;

final readonly class UserResponse implements QueryResponse
{
    public function __construct(
        public int    $id,
        public string $email,
    )
    {
    }
}