<?php

namespace App\Controller;

use App\Refs\Repository\Interfaces\CompanyRepoInterface;
use App\Refs\Repository\Interfaces\PositionRepoInterface;
use App\Refs\Services\RefsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PositionController extends AbstractController
{
    /**
     * @Route("/positions", name="positions")
     * @param PositionRepoInterface $positionRepo
     */
    public function preview(PositionRepoInterface $positionRepo)
    {
        RefsService::preview($positionRepo);
    }
}
