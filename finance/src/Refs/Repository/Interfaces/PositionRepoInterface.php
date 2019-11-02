<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/2/19
 * Time: 4:03 PM
 */

namespace App\Refs\Repository\Interfaces;


interface PositionRepoInterface extends  BaseRefsInterface
{
    public function getWithCompanies(array $company):array;

    public function getWithSalary(array $salary = [], bool $hot = FALSE, bool $active = TRUE):array;

}