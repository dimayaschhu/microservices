<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="base")
     */
    public function index()
    {
        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    /**
     * @Route("/auth", name="auth")
     */
    public function getAuth()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://nginx_auth');

        return $this->json(json_decode($response->getContent()));
    }

    /**
     * @Route("/finance", name="finance")
     */
    public function getFinance()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://nginx_finance');

        return $this->json(json_decode($response->getContent()));
    }
}
