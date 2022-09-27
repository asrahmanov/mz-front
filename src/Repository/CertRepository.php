<?php

namespace App\Repository;

use App\Entity\Cert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cert[]    findAll()
 * @method Cert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cert::class);
    }

    public function getForMainPage()
    {
        return $this->createQueryBuilder('c')
            ->join('c.clinics', 'clinics')
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return Cert[] Returns an array of Cert objects
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
    public function findOneBySomeField($value): ?Cert
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
