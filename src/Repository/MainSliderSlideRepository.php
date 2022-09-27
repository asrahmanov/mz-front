<?php

namespace App\Repository;

use App\Entity\MainSliderSlide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MainSliderSlide|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainSliderSlide|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainSliderSlide[]    findAll()
 * @method MainSliderSlide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainSliderSlideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainSliderSlide::class);
    }

    // /**
    //  * @return MainSliderSlide[] Returns an array of MainSliderSlide objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MainSliderSlide
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
