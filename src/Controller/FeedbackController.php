<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3.4.2020 г.
 * Time: 14:07
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\FeedbackCreateService;
use App\Services\FeedbackShowService;

class FeedbackController
{
    private $feedbackCreateService;

    private $feedbackShowService;

    public function __construct(
        FeedbackCreateService $feedbackCreateService,
        FeedbackShowService $feedbackShowService
    )
    {
        $this->feedbackCreateService = $feedbackCreateService;
        $this->feedbackShowService   = $feedbackShowService;
    }

    public function add(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        return $this->feedbackCreateService->create($payload);
    }

    public function list(): JsonResponse
    {
        return  $this->feedbackShowService->show();
    }
}
