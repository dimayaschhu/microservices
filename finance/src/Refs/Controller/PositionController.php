<?php

namespace App\Refs\Controller;

use App\Refs\Repository\Interfaces\PositionRepoInterface;
use App\Refs\Services\RefsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PositionController extends AbstractController
{
    /**
     * @Route("/positions", name="positions")
     * @param PositionRepoInterface $positionRepo
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function preview(PositionRepoInterface $positionRepo)
    {
        $positions = RefsService::preview($positionRepo);
        return $this->json($positions);
    }

    /**
     * @Route("/positions/search", name="search_positions")
     * @param Request $request
     * @param PositionRepoInterface $positionRepo
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function search(Request $request, PositionRepoInterface $positionRepo)
    {
        $data = json_decode($request->getContent(), TRUE);
        $companies = RefsService::search($positionRepo, $data);
        return $this->json($companies);
    }
}
