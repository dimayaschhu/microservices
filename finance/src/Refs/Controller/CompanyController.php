<?php

namespace App\Refs\Controller;

use App\Refs\Repository\Interfaces\CompanyRepoInterface;
use App\Refs\Services\RefsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/companies", name="companies")
     * @param CompanyRepoInterface $companyRepo
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function preview(CompanyRepoInterface $companyRepo)
    {
        $companies = RefsService::preview($companyRepo);
        return $this->json($companies);
    }

    /**
     * @Route("/companies/search", name="search_companies")
     * @param Request $request
     * @param CompanyRepoInterface $companyRepo
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function search(Request $request, CompanyRepoInterface $companyRepo)
    {
        $data = json_decode($request->getContent(), TRUE);
        $companies = RefsService::search($companyRepo, $data);
        return $this->json($companies);
    }
}
