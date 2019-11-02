<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/2/19
 * Time: 7:02 PM
 */

namespace App\Refs\Services;


use App\Refs\Repository\Interfaces\BaseRefsInterface;

class RefsService implements RefsServiceInterface
{
    public static function preview(BaseRefsInterface $repository)
    {
        return $repository->previewAll();
    }


    public static function search(BaseRefsInterface $repository, array $data)
    {
        return $repository->search($data);
    }
}