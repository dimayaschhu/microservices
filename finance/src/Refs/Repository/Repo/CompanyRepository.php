<?php

namespace App\Refs\Repository\Repo;

use App\Refs\Entity\Company;
use App\Refs\Entity\Position;
use App\Refs\Repository\Interfaces\BaseRefsInterface;
use App\Refs\Repository\Interfaces\CompanyRepoInterface;
use App\Refs\Repository\Interfaces\VacancyRepoInterface;
use App\Refs\Services\RefsService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;

/**
 * @method Company|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Company|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class CompanyRepository extends ServiceEntityRepository implements CompanyRepoInterface
{
    public $registry;
    use BaseRefsRepository;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        parent::__construct($registry, Company::class);
    }


    public function getWithPosition(Position $position, array $salary, bool $hot = FALSE, bool $active = TRUE): array
    {
        // TODO: Implement getWithPosition() method.
    }

    private function transformationForPreview($company)
    {
        $vacancyRepository = new VacancyRepository($this->registry);
        foreach ($company->getVacancies() as $key => $vacancy) {
            $positions[] = $vacancy->getPosition()->getName();
        }
        $positions = array_unique($positions ?? []);
        return [
            'id'                      => $company->getId(),
            'name'                    => $company->getName(),
            'quantity_open_vacancies' => $vacancyRepository->countOpenVacancies($company),
            'quantity_hot_vacancies'  => $vacancyRepository->countHotVacancies($company),
            'all_positions'           => implode(",", $positions),
        ];
    }
}
