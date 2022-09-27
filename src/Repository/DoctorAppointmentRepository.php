<?php

namespace App\Repository;

use App\Entity\DoctorAppointment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DoctorAppointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoctorAppointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoctorAppointment[]    findAll()
 * @method DoctorAppointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorAppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctorAppointment::class);
    }

    // /**
    //  * @return DoctorAppointment[] Returns an array of DoctorAppointment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DoctorAppointment
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
