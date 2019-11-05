<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/4/19
 * Time: 9:44 PM
 */

namespace App\Services\User;


use App\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService implements UserServiceInterface
{
    public $userManager;
    public $tokenStorage;
    public $JWTManager;
    public $encoder;

    public function __construct(
        UserManagerInterface $userManager,
        TokenStorageInterface $tokenStorage,
        JWTTokenManagerInterface $JWTManager,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
        $this->JWTManager = $JWTManager;
        $this->encoder = $encoder;

    }

    public function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    public function update(array $data)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if (isset($data['username'])) {
            $user->setUsername($data['username']);
        }

        if (isset($data['password'])) {
            $user->setPlainPassword($data['password']);
        }
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        if (isset($data['Roles'])) {
            $user->setEmail($data['roles']);
        }

        try {
            $this->userManager->updateUser($user, TRUE);
            $token = $this->JWTManager->create($user);
            return ['token' => $token];
        } catch (\Exception $e) {
            throw new \Exception();
        }
    }

    public function create(array $data)
    {
        $user = new User();
        $user
            ->setUsername($data['username'])
            ->setPlainPassword($data['password'])
            ->setEmail($data['email'])
            ->setEnabled(TRUE)
            ->setRoles(['ROLE_USER'])
            ->setSuperAdmin(FALSE);

        try {
            $this->userManager->updateUser($user, TRUE);
            $token = $this->JWTManager->create($user);
            return ['token' => $token];
        } catch (\Exception $e) {
            throw new \Exception();
        }
    }

    public function preview()
    {
        $user = $this->getUser();
        return [
            'id'       => $user->getId(),
            'username' => $user->getUsername(),
            'email'    => $user->getEmail(),
            'roles'    => $user->getRoles(),
        ];
    }

    public function refreshToken()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        return $this->JWTManager->create($user);
    }

    public function getUserToken(array $credential)
    {
        $user = $this->userManager->findUserByUsername($credential['username']);
        if(!$this->encoder->isPasswordValid($user, $credential['password'])){
            throw new \Exception();
        }
        return $this->JWTManager->create($user);
    }
}