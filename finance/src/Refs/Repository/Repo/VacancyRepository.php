<?php

namespace App\Refs\Repository\Repo;

use App\Refs\Entity\Company;
use App\Refs\Entity\Position;
use App\Refs\Entity\Vacancy;
use App\Refs\Repository\Interfaces\VacancyRepoInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Vacancy|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Vacancy|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Vacancy[]    findAll()
 * @method Vacancy[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class VacancyRepository extends ServiceEntityRepository implements VacancyRepoInterface
{
    use BaseRefsRepository;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vacancy::class);
    }

    public function getWithPosition(Position $position, array $salary, bool $hot = FALSE, bool $active = TRUE): array
    {
        // TODO: Implement getWithPosition() method.
    }

    public function countOpenVacancies(Company $company = NULL, Position $position = NULL): int
    {
        if ($company) {
            return $this->count(['company' => $company, 'active' => TRUE]);
        }
        if ($position) {
            return $this->count(['position' => $position, 'active' => TRUE]);
        }
    }

    public function countHotVacancies(Company $company = NULL, Position $position = NULL): int
    {
        if ($company) {
            return $this->count(['company' => $company, 'active' => TRUE, 'hot' => TRUE]);
        }

        if ($position) {
            return $this->count(['position' => $position, 'active' => TRUE, 'hot' => TRUE]);
        }

        return 0;
    }

    private function transformationForPreview($vacancy)
    {
        return [
            'id'       => $vacancy->getId(),
            'company'  => $vacancy->getCompany()->getName(),
            'position' => $vacancy->getPosition()->getName(),
            'salary'   => $vacancy->getSalary(),
            'hot'      => $vacancy->getHot(),
            'active'   => $vacancy->getActive(),
        ];
    }
}
