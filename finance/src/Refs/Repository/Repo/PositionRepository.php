<?php

namespace App\Refs\Repository\Repo;


use App\Refs\Entity\Position;
use App\Refs\Repository\Interfaces\PositionRepoInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Position|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Position|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class PositionRepository extends ServiceEntityRepository implements PositionRepoInterface
{
    public $registry;
    use BaseRefsRepository;
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        parent::__construct($registry, Position::class);
    }


    public function getWithCompanies(array $company): array
    {
        // TODO: Implement getWithCompanies() method.
    }

    public function getWithSalary(array $salary = [], bool $hot = FALSE, bool $active = TRUE): array
    {
        // TODO: Implement getWithSalary() method.
    }

    private function transformationForPreview($position)
    {
        $vacancyRepository = new VacancyRepository($this->registry);
        foreach ($position->getVacancies() as $key => $vacancy) {
            $companies[]=$vacancy->getCompany()->getName();
        }
        $companies = array_unique($companies??[]);
        return [
            'id'                      => $position->getId(),
            'name'                    => $position->getName(),
            'quantity_open_vacancies' => $vacancyRepository->countOpenVacancies(NULL,$position),
            'quantity_hot_vacancies'  => $vacancyRepository->countHotVacancies(NULL,$position),
            'quantity_company'        => count($companies),
        ];
    }
}
