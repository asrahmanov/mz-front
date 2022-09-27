<?php

namespace App\Repository;

use App\Entity\DoctorRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DoctorRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoctorRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoctorRating[]    findAll()
 * @method DoctorRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctorRating::class);
    }

    // /**
    //  * @return DoctorRating[] Returns an array of DoctorRating objects
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
    public function findOneBySomeField($value): ?DoctorRating
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
