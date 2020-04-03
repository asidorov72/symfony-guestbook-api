<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3.4.2020 г.
 * Time: 14:45
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function index(): Response
    {
        return new Response(null, Response::HTTP_NOT_FOUND);
    }
}