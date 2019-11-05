<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/4/19
 * Time: 8:41 PM
 */

namespace App\Controller\Requests;


use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class RegisterRequestValidator
{
    public $repository;


    public function __construct(UserManagerInterface $userManager)
    {
        $this->repository = $userManager;
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
        if ($this->repository->findUserBy(['username' => $data['username'] ?? NULL]) != NULL) {
            $errors[] = [
                'field'   => 'username',
                'message' => 'дане назва зайнятв',
            ];
        }

        if ($this->repository->findUserBy(['email' => $data['email'] ?? NULL]) != NULL) {
            $errors[] = [
                'field'   => 'email',
                'message' => 'дане email зайнятв',
            ];
        }

        return $errors;
    }
}