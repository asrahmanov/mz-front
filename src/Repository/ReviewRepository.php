<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function getForMainPage()
    {
        return $this->createQueryBuilder('r')
            ->where('r.isPublished = true')
            ->setMaxResults(4)
            ->orderBy('r.video', 'desc')
            ->getQuery()
            ->getResult()
        ;
    }

    public function filter(array $filter)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->andWhere('r.isPublished = TRUE');

        if (isset($filter['doctor']) || isset($filter['specialty'])) {
            $qb->join('r.doctors', 'doctors');
        }

        if(isset($filter['doctor'])) {
            $qb->andWhere('doctors in (:doctor)')
                ->setParameter('doctor', [$filter['doctor']]);
        }

        if(isset($filter['specialty'])) {
            $qb->join('doctors.specialties', 'specialties')
                ->andWhere('specialties in (:specialties)')
                ->setParameter('specialties', [$filter['specialty']]);
        }

        if(isset($filter['clinic'])) {
            $qb->join('r.clinic', 'clinic')
                ->andWhere('clinic = :clinic')
                ->setParameter('clinic', [$filter['clinic']]);
        }

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Review[] Returns an array of Review objects
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
    public function findOneBySomeField($value): ?Review
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
