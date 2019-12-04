<?php

namespace App\Repository;

use App\Entity\Classroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Classroom|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classroom|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classroom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassroomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classroom::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.start_at', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByGroup($group)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.student_group = :group')
            ->setParameter('group', $group)
            ->orderBy('c.start_at', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByTeacherId($id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.teacher = :id')
            ->setParameter('id', $id)
            ->orderBy('c.start_at', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByOneById($id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult()
            ;
    }

    // /**
    //  * @return Classroom[] Returns an array of Classroom objects
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
    public function findOneBySomeField($value): ?Classroom
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
