<?php
declare(strict_types=1);

namespace App\Modules\User\Application\FindUserByCredentials;

use App\Modules\User\Domain\Model\User;
use App\Modules\User\Domain\Service\HashPassword;
use App\Modules\User\Domain\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class FindUserByCredentialsQueryHandler
{
    public function __construct(
        private UserRepository $repository,
        private HashPassword   $hashPassword,
    )
    {
    }

    public function __invoke(FindUserByCredentialsQuery $query): ?User
    {
        return $this->repository->findUserByEmailAndPassword(
            $query->email,
            $this->hashPassword->__invoke($query->password),
        );
    }

}