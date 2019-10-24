<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 10/23/19
 * Time: 7:18 PM
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Product|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByUsername($username): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}