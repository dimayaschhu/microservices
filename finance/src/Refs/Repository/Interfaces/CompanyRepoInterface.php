<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/2/19
 * Time: 2:45 PM
 */

namespace App\Refs\Repository\Interfaces;


use App\Refs\Entity\Position;

interface CompanyRepoInterface extends  BaseRefsInterface
{
    public function getWithPosition(Position $position, array $salary, bool $hot = FALSE, bool $active = TRUE):array;
}