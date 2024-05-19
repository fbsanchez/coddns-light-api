<?php
declare(strict_types=1);

namespace App\Controller\Shared;

use Symfony\Component\HttpFoundation\Request;

trait ParametersTrait
{

    private function parameters(Request $request): array
    {
        return $this->customParameters(
            array_merge(
                $request->request->all(),
                json_decode($request->getContent(), true) ?? [],
            ),
        );
    }

    public function customParameters(array $parameters): array
    {
        return $parameters;
    }
}