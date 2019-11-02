<?php

namespace App\Controller;

use App\Refs\Repository\Interfaces\VacancyRepoInterface;
use App\Refs\Services\RefsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VacancyController extends AbstractController
{
    /**
     * @Route("/vacancies", name="vacancies")
     * @param VacancyRepoInterface $vacancyRepo
     */
    public function preview(VacancyRepoInterface $vacancyRepo)
    {
        RefsService::preview($vacancyRepo);
    }
}
