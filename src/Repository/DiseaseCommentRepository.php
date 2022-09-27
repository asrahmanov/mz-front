<?php

namespace App\Repository;

use App\Entity\DiseaseComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DiseaseComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiseaseComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiseaseComment[]    findAll()
 * @method DiseaseComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiseaseCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiseaseComment::class);
    }

    // /**
    //  * @return DiseaseComment[] Returns an array of DiseaseComment objects
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
    public function findOneBySomeField($value): ?DiseaseComment
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
