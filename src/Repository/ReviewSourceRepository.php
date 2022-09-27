<?php

namespace App\Repository;

use App\Entity\ReviewSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReviewSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReviewSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReviewSource[]    findAll()
 * @method ReviewSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewSourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReviewSource::class);
    }

    // /**
    //  * @return ReviewSource[] Returns an array of ReviewSource objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReviewSource
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
