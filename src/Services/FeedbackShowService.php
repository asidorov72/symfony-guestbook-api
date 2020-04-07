<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5.4.2020 г.
 * Time: 20:17
 */

namespace App\Services;

use App\Repository\FeedbackRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
class FeedbackShowService
{
    public const EXCLUDE_WORDS_ARRAY = ['test1', 'test2'];

    private $feedbackRepository;

    private $monologLogger;

    public function __construct(
        FeedbackRepository $feedbackRepository,
        LoggerInterface $monologLogger
    )
    {
        $this->feedbackRepository = $feedbackRepository;
        $this->monologLogger      = $monologLogger;
    }

    public function show() : JsonResponse
    {
        try {
            $feedbackList = $this->feedbackRepository->findMessages(
                [
                    'exclude' => self::EXCLUDE_WORDS_ARRAY,
                    'orderBy' => ['field' => 'date', 'order' => 'desc'],
                    'limit' => 10
                ]
            );

            $this->monologLogger->info('Feedback list was loaded successfully');
        } catch(\Exception $e) {
            $this->monologLogger->error($e->getMessage());

            return new JsonResponse(['errorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        if (empty($feedbackList)) {
            $this->monologLogger->error('Nothing was found.');

            return new JsonResponse(['errorMessage' => 'Nothing was found.'], Response::HTTP_BAD_REQUEST);
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
