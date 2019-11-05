<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/4/19
 * Time: 9:32 PM
 */

namespace App\Services\User;


interface UserServiceInterface
{
    public function refreshToken();

    public function getUserToken(array $credential);

    public function getUser();

    public function preview();

    public function update(array $data);

    public function create(array $data);
}