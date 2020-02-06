<?php

namespace App\Repository;

use App\Entity\ApiTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ApiTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiTest[]    findAll()
 * @method ApiTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiTest::class);
    }

    // /**
    //  * @return ApiTest[] Returns an array of ApiTest objects
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
    public function findOneBySomeField($value): ?ApiTest
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
