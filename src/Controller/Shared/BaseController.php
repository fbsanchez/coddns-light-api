<?php
declare(strict_types=1);

namespace App\Controller\Shared;

use App\Controller\Shared\Service\Authentication;
use App\Modules\User\Domain\Model\User;
use App\Shared\Domain\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class BaseController extends AbstractController
{
    use ParametersTrait;

    private Authentication $authentication;

    public function requireAuthentication(): bool
    {
        return true;
    }

    public function __invoke(
        Request             $request,
        MessageBusInterface $messageBus,
        Authentication      $authentication,
    ): Response
    {
        if (true === $this->requireAuthentication()) {
            $this->authentication = $authentication;
            $this->authentication->getUser(
                $request->headers->get('Authorization'),
            );
        }

        $messageBus->dispatch($this->mapCommand($this->parameters($request)));
        return $this->response();
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

    abstract function command(): string;

    public function getAuthUser(): User
    {
        return $this->authentication->getUser();
    }

}