<?php

namespace App\Repository;

use App\Entity\DiseaseCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DiseaseCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiseaseCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiseaseCategory[]    findAll()
 * @method DiseaseCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiseaseCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiseaseCategory::class);
    }

    // /**
    //  * @return DiseaseCategory[] Returns an array of DiseaseCategory objects
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
    public function findOneBySomeField($value): ?DiseaseCategory
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
