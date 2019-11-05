<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/4/19
 * Time: 9:32 PM
 */

namespace App\Services\User;


use App\Entity\User;

interface UserServiceInterface
{
    public function getUser();

    public function update(array $data);

    public function create(array $data);
}