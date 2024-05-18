<?php
declare(strict_types=1);

namespace App\Controller\Shared;

use App\Shared\Domain\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class BaseController extends AbstractController
{
    public function __invoke(
        Request             $request,
        MessageBusInterface $messageBus,
    ): JsonResponse
    {
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

    public function parameters(Request $request): array
    {
        return array_merge(
            $request->request->all(),
            json_decode($request->getContent(), true),
        );
    }

    public function response(): JsonResponse
    {
        return new JsonResponse();
    }

    abstract function command(): string;

}