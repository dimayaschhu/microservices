<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;


/**
 * @method Company|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Company|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    // /**
    //  * @return Company[] Returns an array of Company objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Company
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function searchNativeQuery($name = NULL, $price = NULL, $number = NULL, $limit = 10)
    {
        $limit=$limit??10;
        $qb = $this->createQueryBuilder('c');
        if (!\is_null($name)) {
            $qb->andWhere($qb->expr()->like('c.name', ':name'))
                ->setParameter('name', "%{$name}%");
        }

        if (!\is_null($price)) {
            $qb->andWhere($qb->expr()->like('c.price', ':price'))
                ->setParameter('price', "%{$price}%");
        }

        if (!\is_null($number)) {
            $qb->andWhere($qb->expr()->like('c.number', ':number'))
                ->setParameter('number', "%{$number}%");
        }
        return $qb->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
