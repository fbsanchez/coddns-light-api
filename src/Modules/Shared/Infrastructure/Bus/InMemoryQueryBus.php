<?php
declare(strict_types=1);

namespace App\Modules\Shared\Infrastructure\Bus;

use App\Modules\Shared\Domain\Query;
use App\Modules\Shared\Domain\QueryBus;
use App\Modules\Shared\Domain\QueryHandler;
use App\Modules\Shared\Domain\QueryResponse;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

final readonly class InMemoryQueryBus implements QueryBus, ServiceSubscriberInterface
{

    public function __construct(
        private ContainerInterface $locator,
    )
    {
    }

    public function ask(Query $query): QueryResponse|array|null
    {
        $handlerClass = $query::class.'Handler';

        $handler = $this->locator->get($handlerClass);

        return $handler->__invoke($query);
    }

    public static function getSubscribedServices(): array
    {
        $subscribedServices = array_values(
            array_filter(
                get_declared_classes(),
                static fn($className) => in_array(QueryHandler::class, class_implements($className)),
            ),
        );

        return $subscribedServices;
    }
}