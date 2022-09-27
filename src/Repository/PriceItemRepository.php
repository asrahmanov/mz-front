<?php

namespace App\Repository;

use App\Entity\PriceItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PriceItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceItem[]    findAll()
 * @method PriceItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceItem::class);
    }

    // /**
    //  * @return PriceItem[] Returns an array of PriceItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PriceItem
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
