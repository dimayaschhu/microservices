<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/2/19
 * Time: 4:04 PM
 */

namespace App\Refs\Repository\Interfaces;


use App\Refs\Entity\Company;
use App\Refs\Entity\Position;

interface VacancyRepoInterface extends BaseRefsInterface
{
    public function getWithPosition(Position $position, array $salary, bool $hot = FALSE, bool $active = TRUE): array;

    public function countOpenVacancies(Company $companyId = null);

    public function countHotVacancies(Company $companyId = null);

}