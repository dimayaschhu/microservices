<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    private $client;

    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    /**
     * @Route("/auth/register", name="auth_register",methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function register(Request $request)
    {
        $response = $this->client->request('POST', 'http://nginx_auth/register', ['body' => $request->getContent()]);
        return $this->json(json_decode($response->getContent()));
    }

    /**
     * @Route("/auth/login", name="auth_login",methods={"POST"})
     */
    public function login()
    {
        $response = $this->client->request('POST', 'http://nginx_auth/login');

        return $this->json(json_decode($response->getContent()));
    }

    /**
     * @Route("/auth/user", name="auth_get_register",methods={"GET"})
     */
    public function receiveUser()
    {
        $response = $this->client->request('GET', 'http://nginx_auth/api/user');

        return $this->json(json_decode($response->getContent()));
    }

    /**
     * @Route("/auth/user", name="auth_update_register",methods={"POST"})
     */
    public function updateUser()
    {
        $response = $this->client->request('POST', 'http://nginx_auth/api/user');

        return $this->json(json_decode($response->getContent()));
    }
}