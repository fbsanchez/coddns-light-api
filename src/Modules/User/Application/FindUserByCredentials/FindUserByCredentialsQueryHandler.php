<?php
declare(strict_types=1);

namespace App\Modules\User\Application\FindUserByCredentials;

use App\Modules\User\Domain\Message\UserResponse;
use App\Modules\User\Domain\Service\HashPassword;
use App\Modules\User\Domain\UserRepository;
use App\Shared\Domain\QueryHandler;

final readonly class FindUserByCredentialsQueryHandler implements QueryHandler
{
    public function __construct(
        private UserRepository $repository,
        private HashPassword   $hashPassword,
    )
    {
    }

    public function __invoke(FindUserByCredentialsQuery $query): ?UserResponse
    {
        return $this->repository->findUserByEmailAndPassword(
            $query->email,
            $this->hashPassword->__invoke($query->password),
        )?->toResponse();
    }

}