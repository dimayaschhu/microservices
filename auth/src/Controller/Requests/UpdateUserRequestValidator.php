<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/5/19
 * Time: 7:33 AM
 */

namespace App\Controller\Requests;


use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserRequestValidator
{
    public $repository;
    public $tokenStorage;

    public function __construct(
        UserManagerInterface $userManager,
        TokenStorageInterface $tokenStorage
    ) {
        $this->repository = $userManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function validation(array $data)
    {
        $errors = [];
        $validator = Validation::createValidator();
        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'username' => new Assert\Length(['min' => 1]),
            'password' => new Assert\Length(['min' => 1]),
            'email'    => new Assert\Email(),
        ]);

        $violations = $validator->validate($data, $constraint);
        foreach ($violations as $violation) {
            $errors[] = [
                'field'   => $violation->getParameters()['{{ field }}'],
                'message' => $violation->getMessage(),
            ];
        }
        if (!empty($errors)) {
            return $errors;
        }
        $userAuth = $this->tokenStorage->getToken()->getUser();

        $violations = $validator->validate($data, $constraint);
        foreach ($violations as $violation) {
            $errors[] = [
                'field'   => $violation->getParameters()['{{ field }}'],
                'message' => $violation->getMessage(),
            ];
        }
        $user = $this->repository->findUserBy(['email' => $data['email'] ?? NULL]);
        if ($user != NULL) {
            if ($userAuth->getEmail() != $user->getEmail()) {
                $errors[] = [
                    'field'   => 'email',
                    'message' => 'дане email зайнятв',
                ];
            }
        }

        $user = $this->repository->findUserBy(['username' => $data['username'] ?? NULL]);
        if ($user != NULL) {
            if ($userAuth->getUsername() != $user->getUsername()) {
                $errors[] = [
                    'field'   => 'username',
                    'message' => 'дане назва зайнятв',
                ];
            }
        }

        return $errors;
    }
}