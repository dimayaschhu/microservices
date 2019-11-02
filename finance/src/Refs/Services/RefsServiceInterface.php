<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/2/19
 * Time: 6:57 PM
 */

namespace App\Refs\Services;


use App\Refs\Repository\Interfaces\BaseRefsInterface;

interface RefsServiceInterface
{
    public static function preview(BaseRefsInterface $repository);

    public static function search(BaseRefsInterface $repository,array $data);

}