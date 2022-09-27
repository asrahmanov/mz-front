<?php

namespace App\Repository;

use App\Entity\TreatmentQA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TreatmentQA|null find($id, $lockMode = null, $lockVersion = null)
 * @method TreatmentQA|null findOneBy(array $criteria, array $orderBy = null)
 * @method TreatmentQA[]    findAll()
 * @method TreatmentQA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TreatmentQARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TreatmentQA::class);
    }

    // /**
    //  * @return TreatmentQA[] Returns an array of TreatmentQA objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TreatmentQA
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
