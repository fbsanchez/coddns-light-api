<?php
declare(strict_types=1);

namespace App\Controller\Shared;

use App\Controller\Shared\Service\Authentication;
use App\Modules\Shared\Domain\Query;
use App\Modules\Shared\Domain\QueryBus;
use App\Modules\Shared\Domain\QueryResponse;
use App\Modules\User\Domain\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class QueryController extends AbstractController
{
    private const HEADERS = ['Content-Type' => 'application/json'];
    use ParametersTrait;

    private Authentication $authentication;

    public function __invoke(
        Request        $request,
        QueryBus       $queryBus,
        Authentication $authentication,
    ): Response
    {
        $this->authentication = $authentication;
        $this->authentication->getUser(
            $request->headers->get('Authorization'),
        );

        return $this->response($queryBus->ask($this->mapQuery($this->parameters($request))));
    }

    public function response(QueryResponse|array|null $queryResponse = null): Response
    {
        return new Response(
            json_encode($queryResponse),
            Response::HTTP_OK,
            self::HEADERS,
        );
    }

    public function mapQuery(array $parameters): Query
    {
        $className = $this->query();
        if (
            false === class_exists($className)
            || false === method_exists($className, 'fromPrimitives')
        ) {
            throw new \RuntimeException('Invalid query class: '.$className);
        }

        return $className::fromPrimitives($parameters);
    }

    /** @return class-string<Query> */
    abstract function query(): string;

    public function getAuthUser(): User
    {
        return $this->authentication->getUser();
    }
}