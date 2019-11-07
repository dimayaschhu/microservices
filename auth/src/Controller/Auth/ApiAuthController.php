<?php

namespace App\Controller\Auth;


use App\Controller\Auth\Requests\LoginRequestValidator;
use App\Controller\Auth\Requests\RegisterRequestValidator;
use App\Services\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidatorException;

class ApiAuthController extends AbstractController
{
    /**
     * @Route("/register", name="api_auth_register",  methods={"POST"})
     * @param Request $request
     * @param RegisterRequestValidator $validator
     * @param UserServiceInterface $userService
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function register(Request $request, RegisterRequestValidator $validator, UserServiceInterface $userService)
    {
        $data = json_decode($request->getContent(), TRUE)??[];
        try {
            $validator->validation($data);
            return $this->json($userService->create($data), 200);
        } catch (ValidatorException $exception) {
            $errors = json_decode($exception->getMessage(), TRUE);
            return $this->json($errors, 422);
        }

    }

    /**
     * @Route("/refresh", name="api_refresh",methods={"POST"})
     * @param UserServiceInterface $userService
     * @return JsonResponse
     */
    public function refresh(UserServiceInterface $userService)
    {
        return $this->json(['token' => $userService->refreshToken()]);
    }

    /**
     * @Route("/login", name="api_login",methods={"POST"})
     * @param LoginRequestValidator $validator
     * @param Request $request
     * @param UserServiceInterface $userService
     * @return JsonResponse
     */
    public function login(LoginRequestValidator $validator, Request $request, UserServiceInterface $userService)
    {
        $data = json_decode($request->getContent(), TRUE);
        try {
            $validator->validation($data);
            return $this->json(['token' => $userService->getUserToken($data)]);
        } catch (ValidatorException $exception) {
            return $this->json(['error' => 'невірний логін або пароль'], 422);
        }
    }
}
