<?php
declare(strict_types=1);

namespace App\Controller\Shared;

use App\Controller\Shared\Service\Authentication;
use App\Modules\Shared\Domain\Exception\DomainException;
use App\Modules\Shared\Domain\Message;
use App\Modules\Shared\Domain\TransactionalPersistenceClient;
use App\Modules\User\Domain\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class BaseController extends AbstractController
{
    use ParametersTrait;

    private Authentication $authentication;

    public function __invoke(
        Request                        $request,
        MessageBusInterface            $messageBus,
        Authentication                 $authentication,
        TransactionalPersistenceClient $persistenceClient,
    ): Response
    {
        if (true === $this->requireAuthentication()) {
            $this->authentication = $authentication;
            $this->authentication->getUser(
                $request->headers->get('Authorization'),
            );
        }

        try {
            $persistenceClient->startTransaction();
            $messageBus->dispatch($this->mapCommand($this->parameters($request)));
            $persistenceClient->commit();
            return $this->response();
        } catch (HandlerFailedException $th) {
            $persistenceClient->rollback();
            $exception = $th->getPrevious();
            $exceptionCode = null;
            $exceptionClass = null;
            if ($exception instanceof DomainException) {
                $exceptionClass = get_class($exception);
                $exceptionCode = $this->mapExceptions($exceptionClass);
            }

            if (null === $exceptionCode || null === $exceptionClass) {
                throw $th;
            }

            return new Response(sprintf('Error %s', $this->exceptionPrettyName($exceptionClass)), $exceptionCode);
        }
    }

    public function requireAuthentication(): bool
    {
        return true;
    }

    public function mapCommand(array $parameters): Message
    {
        $className = $this->command();
        if (
            false === class_exists($className)
            || false === method_exists($className, 'fromPrimitives')
        ) {
            throw new \RuntimeException('Invalid command class: '.$className);
        }

        return $className::fromPrimitives($parameters);
    }

    public function response(): Response
    {
        return new Response();
    }

    /** @param class-string<object> $exceptionClass */
    private function mapExceptions(string $exceptionClass): ?int
    {
        return static::exceptions()[$exceptionClass] ?? null;
    }

    private function exceptionPrettyName(string $exceptionClassName): string
    {
        return preg_replace(
            '/Exception$/',
            '',
            preg_replace('/.*\\\\/', '', $exceptionClassName),
        );
    }

    /** @return class-string<Message> */
    abstract function command(): string;

    public static function exceptions(): array
    {
        return [];
    }

    public function getAuthUser(): User
    {
        return $this->authentication->getUser();
    }

}