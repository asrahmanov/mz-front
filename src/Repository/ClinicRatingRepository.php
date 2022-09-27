<?php

namespace App\Repository;

use App\Entity\ClinicRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClinicRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClinicRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClinicRating[]    findAll()
 * @method ClinicRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClinicRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClinicRating::class);
    }

    // /**
    //  * @return ClinicRating[] Returns an array of ClinicRating objects
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
    public function findOneBySomeField($value): ?ClinicRating
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
