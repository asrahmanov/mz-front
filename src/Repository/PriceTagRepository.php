<?php

namespace App\Repository;

use App\Entity\PriceTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PriceTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceTag[]    findAll()
 * @method PriceTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceTag::class);
    }

    public function getForPrice($filter = [])
    {
        $qb = $this->createQueryBuilder('price_tag')
            ->join('price_tag.priceItems', 'priceItems');
        if (isset($filter['priceItem'])) {
            $qb->andWhere('priceItems.name like :priceName');
            $qb->setParameter('priceName', '%' . $filter['priceItem'] . '%');
        }
        $qb->select(['price_tag']);
        return $qb->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return PriceTag[] Returns an array of PriceTag objects
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
    public function findOneBySomeField($value): ?PriceTag
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
