<?php

namespace App\Refs\Repository\Repo;


use App\Refs\Entity\Position;
use App\Refs\Repository\Interfaces\PositionRepoInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionRepository extends ServiceEntityRepository implements PositionRepoInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Position::class);
    }


    public function previewAll(): array
    {
        $positions = parent::findAll();
        dd($positions);
    }

    public function search($data): array
    {
        // TODO: Implement search() method.
    }

    public function getWithCompanies(array $company): array
    {
        // TODO: Implement getWithCompanies() method.
    }

    public function getWithSalary(array $salary = [], bool $hot = FALSE, bool $active = TRUE): array
    {
        // TODO: Implement getWithSalary() method.
    }
}
