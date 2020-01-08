<?php

namespace App\Repository;

use App\Entity\ClassroomGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClassroomGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassroomGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassroomGroup[]    findAll()
 * @method ClassroomGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassroomGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassroomGroup::class);
    }

    // /**
    //  * @return ClassroomGroup[] Returns an array of ClassroomGroup objects
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
    public function findOneBySomeField($value): ?ClassroomGroup
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
