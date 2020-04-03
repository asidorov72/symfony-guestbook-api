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
//use Symfony\Component\Routing\Exception\RouteNotFoundException;

class FeedbackController
{
    private $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * @Route("/feedback/add", name="add_feedback", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        die('ХУЙ');

//        $firstName = $data['firstName'];
//        $lastName = $data['lastName'];
//        $email = $data['email'];
//        $phoneNumber = $data['phoneNumber'];
//
//        if (empty($firstName) || empty($lastName) || empty($email) || empty($phoneNumber)) {
//            return new JsonResponse(['status' => 'Empty parameters were given!'], Response::HTTP_BAD_REQUEST);
//        }
//
//        try{
//            $this->customerRepository->saveCustomer($firstName, $lastName, $email, $phoneNumber);
//        } catch(\Exception $e) {
//            return new JsonResponse(['status' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
//
//        return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }
}
