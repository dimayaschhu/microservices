<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FinanceController extends AbstractController
{
    private $client;


    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    /**
     * @Route("/companies", name="api_companies", methods={"GET"})
     * @return JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function companies()
    {
        $response = $this->client->request('GET', 'http://nginx_finance/companies');
        $companies = json_decode($response->getContent(), TRUE);
        return $this->json($companies);
    }

    /**
     * @Route("/vacancies", name="api_vacancies", methods={"GET"})
     * @return JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function vacancies()
    {
        $response = $this->client->request('GET', 'http://nginx_finance/vacancies');
        $vacancies=json_decode($response->getContent(),TRUE);
        return $this->json($vacancies);
    }

    /**
     * @Route("/positions", name="api_positions", methods={"GET"})
     * @return JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function positions()
    {
        $response = $this->client->request('GET', 'http://nginx_finance/positions');
        $positions=json_decode($response->getContent(),TRUE);
        return $this->json($positions);
    }
}
