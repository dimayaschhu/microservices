<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 10/23/19
 * Time: 8:17 PM
 */

namespace App\Service;


use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthService
{
    public $encoder;
    public $JWTManager;
    public $doctrineManager;
    public $doctrine;
    public $tokenStorage;
    public $serializer;
    public $validator;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        JWTTokenManagerInterface $JWTManager,
        RegistryInterface $registry,
        TokenStorageInterface $tokenStorage,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->encoder = $encoder;
        $this->JWTManager = $JWTManager;
        $this->doctrine = $registry;
        $this->doctrineManager = $registry->getManager();
        $this->tokenStorage = $tokenStorage;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function register($request): Response
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $user = new User($username);
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $errors = $this->validator->validate($user);

        if ($errors->count() == 0) {
            $this->doctrineManager->persist($user);
            $this->doctrineManager->flush();
            $token = $this->JWTManager->create($user);
            return new Response(json_encode(['token' => $token]));
        } else {
            $messageErrors = [];
            foreach ($errors as $error) {
                $messageErrors[] = [
                    'property' => $error->getPropertyPath(),
                    'message'  => $error->getMessage(),
                ];
            }
            return new Response(json_encode($messageErrors),422);
        }


    }

    public function login($request): Response
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $user = $this->doctrine
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);

        if ($user != NULL && $this->encoder->isPasswordValid($user, $password)) {
            $token = $this->JWTManager->create($user);
            return new Response(json_encode(['token' => $token]), 200);
        }

        return new Response('{"code":401,"message":"Invalid JWT Token"}', 401);
    }

    public function receiveUser()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $user = $this->serializer->serialize($user, 'json');
        return new Response($user);
    }

    public function updateUser($request)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $username = $request->get('username');
        $password = $request->get('password');
        if ($username) {
            $user->setUsername($username);
        }
        if ($password) {
            $user->setPassword($this->encoder->encodePassword($user, $password));
        }
        $this->doctrineManager->persist($user);
        $this->doctrineManager->flush();
        $token = $this->JWTManager->create($user);
        return new Response(json_encode(['token' => $token]), 200);

    }


}