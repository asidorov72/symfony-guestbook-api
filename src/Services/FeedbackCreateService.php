<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.4.2020 г.
 * Time: 19:54
 */

namespace App\Services;

use App\Repository\FeedbackRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Validator\FeedbackRequestValidator;
use Psr\Log\LoggerInterface;

class FeedbackCreateService
{
    private $feedbackRepository;

    private $feedbackRequestValidator;

    private $monologLogger;

    public function __construct(
        FeedbackRepository $feedbackRepository,
        FeedbackRequestValidator $feedbackRequestValidator,
        LoggerInterface $monologLogger
    )
    {
        $this->feedbackRepository       = $feedbackRepository;
        $this->feedbackRequestValidator = $feedbackRequestValidator;
        $this->monologLogger            = $monologLogger;
    }

    public function create(array $payload) : JsonResponse
    {
        try {
            $this->feedbackRequestValidator->validate($payload);
        } catch (\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        try{
            $this->feedbackRepository->saveFeedback($payload);
            $this->monologLogger->info('Feedback was created!');
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'Feedback was created!'], Response::HTTP_CREATED);
    }
}
