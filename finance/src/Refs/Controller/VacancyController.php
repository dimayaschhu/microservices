<?php

namespace App\Refs\Controller;

use App\Refs\Repository\Interfaces\VacancyRepoInterface;
use App\Refs\Services\RefsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VacancyController extends AbstractController
{
    /**
     * @Route("/vacancies", name="vacancies")
     * @param VacancyRepoInterface $vacancyRepo
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function preview(VacancyRepoInterface $vacancyRepo)
    {
        $vacancies = RefsService::preview($vacancyRepo);
        return $this->json($vacancies);
    }

    /**
     * @Route("/vacancies/search", name="search_vacancies")
     * @param Request $request
     * @param VacancyRepoInterface $vacancyRepo
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function search(Request $request, VacancyRepoInterface $vacancyRepo)
    {
        $data = json_decode($request->getContent(), TRUE);
        $companies = RefsService::search($vacancyRepo, $data);
        return $this->json($companies);
    }
}
