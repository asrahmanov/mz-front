<?php

namespace App\Repository;

use App\Entity\Doctor;
use App\Entity\DoctorScheduleDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DoctorScheduleDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoctorScheduleDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoctorScheduleDate[]    findAll()
 * @method DoctorScheduleDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorScheduleDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctorScheduleDate::class);
    }

    public function findNearestReceptionDate(Doctor $doctor)
    {
        $today = (new \DateTime())->setTime(0, 0, 0);
        $result = $this->createQueryBuilder('date')
            ->join('date.doctorSchedules', 'schedules')
            ->join('schedules.doctor', 'doctor')
            ->andWhere('doctor.id = :doctorId')
            ->andWhere('date.date >= :today')
            ->setParameter('doctorId', $doctor->getId())
            ->setParameter('today', $today)
            ->orderBy('date.date', 'ASC')
            ->getQuery()->setMaxResults(1)->getOneOrNullResult()
            ;
        return $result;
    }

    // /**
    //  * @return ScheduleDate[] Returns an array of ScheduleDate objects
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
    public function findOneBySomeField($value): ?ScheduleDate
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
