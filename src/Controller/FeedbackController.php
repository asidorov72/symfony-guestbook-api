<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3.4.2020 г.
 * Time: 14:07
 */

namespace App\Controller;

use App\Repository\FeedbackRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Validator\FeedbackRequestValidator;

class FeedbackController
{
    private $feedbackRepository;

    public function __construct(
        FeedbackRepository $feedbackRepository,
        FeedbackRequestValidator $feedbackRequestValidator
    )
    {
        $this->feedbackRepository       = $feedbackRepository;
        $this->feedbackRequestValidator = $feedbackRequestValidator;
    }

    public function add(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        try {
            $this->feedbackRequestValidator->validate($payload);
        } catch (\Exception $e) {
            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        try{
            $this->feedbackRepository->saveFeedback($payload);
        } catch(\Exception $e) {
            return new JsonResponse(['status' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'Feedback was created!'], Response::HTTP_CREATED);
    }
}
