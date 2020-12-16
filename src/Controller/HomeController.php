<?php

namespace App\Controller;

use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="meal_list", methods={"GET"})
     * @param Request $request
     * @param MealRepository $mealRepository
     * @return JsonResponse
     */
    public function searchAction(Request $request, MealRepository $mealRepository): JsonResponse
    {
        if($request->query->count() !== 0) {

            foreach ($request->query as $query => $value) {
                if (isset($query, $value)) {
                    $filter[] = $query;
                    $data = $mealRepository->filter($request->query);
                }
            }
            if (!in_array('lang', $filter)) {
                $langError = [
                    'status:'=> 'error',
                    'code:'=> 'invalid lang parameter',
                    'message:'=> 'Lang parameter is required.'
                ];
            }

        } else {
            $langError = [
                'status:'=> 'error',
                'code:'=> 'invalid lang parameter',
                'message:'=> 'Lang parameter is required.'
            ];
        }

        $errors = $mealRepository->getErrors();
        if(isset($langError)) {
            array_push($errors, $langError);
        }

        if(!empty($errors)) {
            $response = [
                'error' => $errors
            ];
        } else {
            $response = [
                'meta' => $mealRepository->getMeta(),
                'data' => $data
            ];
        }

        return new JsonResponse($response, 200);
    }
}

