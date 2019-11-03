<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/3/19
 * Time: 1:22 PM
 */

namespace App\Refs\Repository\Repo;


use Doctrine\ORM\ORMException;

trait BaseRefsRepository
{
    public function previewAll(): array
    {
        foreach (parent::findAll() as $value) {
            $data[] = $this->transformationForPreview($value);
        }
        return $data ?? [];
    }

    public function search(array $data): array
    {
        try{
            foreach (parent::findBy($data) as $value) {
                $result[] = $this->transformationForPreview($value);
            }
        }catch (ORMException $exception){
            //TODO add text
        }

        return $result ?? [];
    }
}