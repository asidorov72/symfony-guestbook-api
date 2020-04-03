<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3.4.2020 г.
 * Time: 14:08
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class SystemController
{
    public function healthcheck(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
