<?php

namespace App\Repository;

use App\Entity\Absence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Absence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Absence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Absence[]    findAll()
 * @method Absence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Absence::class);
    }

    public function findOneEntityByClassroomIdAndUserId($classroom_id, $user_id)
    {
        return $this->createQueryBuilder('a')
            ->where('a.classroom_id = :classroom_id')
            ->andWhere('a.user_id = :user_id')
            ->setParameter('classroom_id', $classroom_id)
            ->setParameter('user_id', $user_id)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneArrayByClassroomIdAndUserId($classroom_id, $user_id)
    {
        return $this->createQueryBuilder('a')
            ->where('a.classroom_id = :classroom_id')
            ->andWhere('a.user_id = :user_id')
            ->setParameter('classroom_id', $classroom_id)
            ->setParameter('user_id', $user_id)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByClassroomId($classroom_id)
    {
        return $this->createQueryBuilder('a')
            ->where('a.classroom_id = :classroom_id')
            ->setParameter('classroom_id', $classroom_id)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Absence[] Returns an array of Absence objects
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
    public function findOneBySomeField($value): ?Absence
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
