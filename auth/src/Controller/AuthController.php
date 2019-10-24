<?php

namespace App\Controller;


use App\Service\AuthService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AuthController implements ContainerAwareInterface
{
    public $container;
    public $authService;



    private function first()
    {
        $encoder = $this->container->get('security.password_encoder');
        $JWTManager = $this->container->get('lexik_jwt_authentication.jwt_manager');
        $doctrine = $this->container->get('doctrine');
        $tokenStorage = $this->container->get('security.token_storage');
        $serializer = $this->container->get('serializer');
        $validator = $this->container->get('validator');


        $this->authService = new AuthService($encoder, $JWTManager, $doctrine, $tokenStorage,$serializer,$validator);
    }

    public function register(Request $request)
    {
        $this->first();
        return $this->authService->register($request);
    }

//
    public function login(Request $request)
    {
        $this->first();
        return $this->authService->login($request);
    }

    public function receiveUser()
    {
        $this->first();
        return $this->authService->receiveUser();
    }

    public function updateUser(Request $request)
    {
        $this->first();
        return $this->authService->updateUser($request);
    }
//

    /**
     * Sets the container.
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = NULL)
    {
        $this->container = $container;
    }
}