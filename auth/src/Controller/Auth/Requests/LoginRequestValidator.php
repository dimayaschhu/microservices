<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/4/19
 * Time: 8:41 PM
 */

namespace App\Controller\Auth\Requests;


use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

class LoginRequestValidator
{
    public function validation(array $data)
    {
        $errors = [];
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'username' => new Assert\Length(['min' => 1]),
            'password' => new Assert\Length(['min' => 1]),
        ]);

        $violations = $validator->validate($data, $constraint);
        foreach ($violations as $violation) {
            $errors[] = [
                'field'   => $violation->getParameters()['{{ field }}'],
                'message' => $violation->getMessage(),
            ];
        }
        if (!empty($errors)) {
            throw new ValidatorException();
        }
    }
}