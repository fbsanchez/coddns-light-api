<?php
declare(strict_types=1);

namespace App\Controller\Shared;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class HelloWorldController extends AbstractController
{
    public function __invoke(): Response
    {
        return new Response(json_encode(['hello' => 'world']));
    }

}