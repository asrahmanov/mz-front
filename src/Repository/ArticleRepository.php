<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function search($filter, $pageNum = 1, $limit = 5)
    {
        $qb = $this->createQueryBuilder('article');

        if ($filter['tag_slug'] ?? null) {
            $qb->leftJoin('article.tags', 'tags')
                ->andWhere('tags.slug = :tag_slug')
                ->setParameter('tag_slug', $filter['tag_slug'])
            ;
        }

        if ($filter['doctor'] ?? null) {
            $qb->leftJoin('article.author', 'author')
                ->andWhere('author.id = :doctor_id')
                ->setParameter('doctor_id', $filter['doctor'])
            ;
        }

        if ($filter['name'] ?? null) {
            $qb->andWhere('article.name LIKE :name')
                ->setParameter('name', '%' . $filter['name'] . '%')
            ;
        }

        if ($val = $filter['order']['created_at'] ?? null) {
            $qb->addOrderBy('article.createdAt', $val);
        }

        if ($val = $filter['order']['rating'] ?? null) {
            $qb->addOrderBy('article.rating', $val);
        }

        if ($val = $filter['order']['comments'] ?? null) {
            $qb->leftJoin('article.comments', 'comments');
            $qb->addSelect('COUNT(comments.id) AS HIDDEN comments_count');
            $qb->orderBy('comments_count', $val);
        }

        $qb->groupBy('article');

        return new Paginator($qb->getQuery(), $pageNum, $limit);
    }

    public function getPopular($exclude = null, $limit = 3)
    {
         $qb = $this->createQueryBuilder('article')
            ->andWhere('article.isPopular = TRUE');
         if (is_array($exclude)) {
             $qb->andWhere('article.id NOT IN (:exclude)')
                 ->setParameter('exclude', $exclude)
             ;
         }
         return $qb->setMaxResults($limit)
             ->getQuery()
             ->getResult()
         ;
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
