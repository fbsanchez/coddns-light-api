<?php
declare(strict_types=1);

namespace App\Controller\Shared\Service;

use App\Modules\Shared\Domain\QueryBus;
use App\Modules\User\Application\FindUserByCredentials\FindUserByCredentialsQuery;
use App\Modules\User\Domain\Message\UserResponse;
use App\Modules\User\Domain\Model\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final class Authentication
{
    private ?User $user = null;

    public function __construct(
        private readonly QueryBus $queryBus,
    )
    {
    }

    public function getUser(?string $authHeader = null): User
    {
        if (null !== $authHeader) {
            [$email, $password] = $this->decodeAuthHeader($authHeader);
        }

        if (null !== $this->user) {
            return $this->user;
        }

        if (false === isset($email)) {
            throw new UnauthorizedHttpException("", "Not allowed");
        }

        /** @var UserResponse|null $user */
        $user = $this->queryBus->ask(new FindUserByCredentialsQuery($email, $password));
        if (null === $user) {
            throw new UnauthorizedHttpException("", "Not allowed");
        }

        $this->user = new User(
            $user->id,
            $user->email,
        );

        return $this->user;
    }

    private function decodeAuthHeader(string $authHeader): array
    {
        $auth = \Safe\base64_decode(str_replace('Basic ', '', $authHeader));
        return explode(':', $auth);
    }
}