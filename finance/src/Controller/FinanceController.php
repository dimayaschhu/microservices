<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FinanceController extends AbstractController
{
    /**
     * @Route("/", name="finance", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to FinanceController!',
            'path'    => 'src/Controller/FinanceController.php',
        ]);
    }
}
