<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/", name="auth")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to AuthController',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }
}
