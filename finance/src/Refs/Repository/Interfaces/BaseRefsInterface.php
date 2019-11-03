<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11/2/19
 * Time: 7:00 PM
 */

namespace App\Refs\Repository\Interfaces;


interface BaseRefsInterface
{
    public function previewAll():array;

    public function search(array $data):array;

}