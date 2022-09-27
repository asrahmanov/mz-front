<?php

namespace App\Repository;

use App\Entity\PriceCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method PriceCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceCategory[]    findAll()
 * @method PriceCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceCategory::class);
    }

    public function getForPrice($filter = [])
    {
        $qb = $this->createQueryBuilder('price_category')
            ->leftJoin('price_category.priceItems', 'price_items')
            ->leftJoin('price_category.categories', 'subcategories')
            ->leftJoin('subcategories.priceItems', 'subcategory_items')
            ->leftJoin('price_items.doctors', 'doctors')
            ->leftJoin('subcategory_items.doctors', 'subcategory_doctors')
            ->leftJoin('price_items.tags', 'tags')
            ->andWhere('price_category.parrentCategory IS NULL');
        if (isset($filter['doctorId'])) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->eq('doctors.id', $filter['doctorId']),
                    $qb->expr()->eq('subcategory_doctors.id', $filter['doctorId']),
                )
            );
        }
        if (! empty($filter['items'])) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->in('price_items', $filter['items']),
                    $qb->expr()->in('subcategory_items', $filter['items'])
                )
            );
        }
        if (isset($filter['priceItem'])) {
            $qb->andWhere('price_items.name like :priceName');
            $qb->setParameter('priceName', '%' . $filter['priceItem'] . '%');
        }
        return $qb->select(['price_category', 'price_items', 'subcategories', 'subcategory_items', 'tags'])
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return PriceCategory[] Returns an array of PriceCategory objects
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
    public function findOneBySomeField($value): ?PriceCategory
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
