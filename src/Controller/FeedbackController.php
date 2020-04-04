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
use App\Validator\FeedbackRequestValidator;

class FeedbackController
{
    private $feedbackRepository;

    private const EXCLUDE_WORDS_ARRAY = ['test1', 'test2'];

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

    public function list(): JsonResponse
    {
        $feedbackList = $this->feedbackRepository->findLastMessages(self::EXCLUDE_WORDS_ARRAY, 10);

        if (empty($feedbackList)) {
            return new JsonResponse(['status' => 'Nothing was found'], Response::HTTP_BAD_REQUEST);
        }

        $data = [];

        foreach ($feedbackList as $feedback) {
            $data[] = [
                'id' => $feedback->getId(),
                'date' => $feedback->getDate(),
                'author' => $feedback->getAuthor(),
                'email' => $feedback->getEmail(),
                'title' => $feedback->getTitle(),
                'message' => $feedback->getMessage(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
