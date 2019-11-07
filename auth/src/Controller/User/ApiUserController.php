<?php

namespace App\Controller\User;


use App\Controller\Auth\Requests\UpdateUserRequestValidator;
use App\Services\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiUserController extends AbstractController
{
    /**
     * @Route("/", name="api_user_detail", methods={"GET"})
     * @param UserServiceInterface $userService
     * @return JsonResponse
     */
    public function detail(UserServiceInterface $userService)
    {
        return $this->json($userService->preview());
    }

    /**
     * @Route("/update", name="api_user_update", methods={"POST"})
     * @param Request $request
     * @param UserServiceInterface $userService
     * @param UpdateUserRequestValidator $validator
     * @return JsonResponse
     */
    public function update(Request $request,
        UserServiceInterface $userService, UpdateUserRequestValidator $validator
    ) {
        $data = json_decode($request->getContent(), TRUE);
        $errors = $validator->validation($data);
        if (!empty($errors)) {
            return $this->json($errors, 422);
        }
        return $this->json($userService->update($data));
    }
}
