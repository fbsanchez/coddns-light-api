<?php
declare(strict_types=1);

namespace App\Controller\Test;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class TestController extends AbstractController
{
    public function __invoke()
    {
        return new Response(json_encode(['result' => 'success']));
    }

}