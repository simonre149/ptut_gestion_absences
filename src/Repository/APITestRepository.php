<?php

namespace App\Repository;

use App\Entity\APITest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method APITest|null find($id, $lockMode = null, $lockVersion = null)
 * @method APITest|null findOneBy(array $criteria, array $orderBy = null)
 * @method APITest[]    findAll()
 * @method APITest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class APITestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, APITest::class);
    }

    // /**
    //  * @return APITest[] Returns an array of APITest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?APITest
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
