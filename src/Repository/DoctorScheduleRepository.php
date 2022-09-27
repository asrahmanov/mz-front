<?php

namespace App\Repository;

use App\Entity\DoctorSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DoctorSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoctorSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoctorSchedule[]    findAll()
 * @method DoctorSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctorSchedule::class);
    }

    // /**
    //  * @return Schedule[] Returns an array of Schedule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Schedule
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
