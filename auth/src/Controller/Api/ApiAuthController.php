<?php

namespace App\Controller\Api;

use App\Controller\Requests\RegisterRequestValidator;
use App\Services\User\UserServiceInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/auth")
 */
class ApiAuthController extends AbstractController
{
    /**
     * @Route("/register", name="api_auth_register",  methods={"POST"})
     * @param Request $request
     * @param RegisterRequestValidator $registerRequestValidator
     * @param UserServiceInterface $userService
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function register(
        Request $request,
        RegisterRequestValidator $registerRequestValidator,
        UserServiceInterface $userService
    ) {
        $data = json_decode($request->getContent(), TRUE);
        $errors = $registerRequestValidator->validation($data);
        if (!empty($errors)) {
            return $this->json($errors, 422);
        }
        try {
            return $this->json($userService->create($data), 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }

    }

    /**
     * @Route("/refresh", name="api_refresh",methods={"POST"})
     * @param TokenStorageInterface $tokenStorage
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function refresh(
        TokenStorageInterface $tokenStorage,
        JWTTokenManagerInterface $JWTManager
    ) {
        $user = $tokenStorage->getToken()->getUser();
        return $this->json(['token' => $JWTManager->create($user)]);
    }
}
