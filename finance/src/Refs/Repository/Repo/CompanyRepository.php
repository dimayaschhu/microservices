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

/**
 * @method Company|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Company|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class CompanyRepository extends ServiceEntityRepository implements CompanyRepoInterface
{
    public $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        parent::__construct($registry, Company::class);
    }


    public function previewAll(): array
    {
        $companies = [];

        foreach (parent::findAll() as $company) {
            $companies[] = $this->transformationForPreview($company);
        }
        return $companies;
    }

    public function search($data): array
    {
        // TODO: Implement search() method.
    }

    public function getWithPosition(Position $position, array $salary, bool $hot = FALSE, bool $active = TRUE): array
    {
        // TODO: Implement getWithPosition() method.
    }

    private function transformationForPreview($company)
    {
        $vacancyRepository = new VacancyRepository($this->registry);

        $positions = '';
        foreach ($company->getVacancies() as $key => $vacancy) {
            $position = $vacancy->getPosition()->getName();
            $positions .= (strpos($positions, $position) === FALSE) ? $position . ', ':'';
        }
        return [
            'id'                      => $company->getId(),
            'name'                    => $company->getName(),
            'quantity_open_vacancies' => $vacancyRepository->countOpenVacancies($company),
            'quantity_hot_vacancies'  => $vacancyRepository->countHotVacancies($company),
            'all_positions'           => $positions,
        ];
    }
}
