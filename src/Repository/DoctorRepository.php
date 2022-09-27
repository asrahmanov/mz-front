<?php

namespace App\Repository;

use App\Entity\Doctor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Doctor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Doctor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Doctor[]    findAll()
 * @method Doctor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Doctor::class);
    }

    public function search($filter = [])
    {
        $qb = $this->createQueryBuilder('doctors');
        if (isset($filter['name'])) {
            $qb->addSelect('CONCAT(doctors.lastname, \' \', doctors.middlename, \' \', doctors.firstname) AS HIDDEN name')
                ->andHaving('name like :name')
                ->setParameter('name', '%'. $filter['name'].'%')
            ;
        }

        if (isset($filter['speciality'])) {
            $qb->join('doctors.specialties', 'specialties')
                ->andWhere('specialties.id = :specialityId')
                ->setParameter('specialityId', $filter['speciality'])
            ;
        }

        if (isset($filter['category'])) {
            $qb->andWhere('doctors.category LIKE :category')
                ->setParameter('category', $filter['category'])
            ;
        }

        if (isset($filter['clinic'])) {
            $qb->join('doctors.clinics', 'clinics')
                ->andWhere('clinics.id = :clinicId')
                ->setParameter('clinicId', $filter['clinic'])
            ;
        }

        if ($filter['onlineConsultation'] ?? false) {
            $qb->andWhere('doctors.onlineConsultation = TRUE');
        }

        if ($filter['today'] ?? false) {
            $qb->join('doctors.schedules', 'schedules')
                ->join('schedules.dates', 'dates')
                ->andWhere('dates.date = :date')
                ->setParameter('date', (new \DateTime())->setTime(0, 0, 0));
        }

        if ($filter['promo'] ?? false) {
            $qb->andWhere('doctors.promo = TRUE');
        }

        $qb->andWhere('doctors.isEnabled = TRUE');

        $qb->addOrderBy('doctors.leadingSpecialist', 'DESC');
        $result = $qb->getQuery()->getResult();
        return $result;
    }

    public function getForPrice($filter = [])
    {
        $qb = $this->createQueryBuilder('doctor');
        $qb->join('doctor.priceItems', 'priceItems');
        return $qb->getQuery()
            ->getResult()
        ;
    }

    public function getArticleAuthors()
    {
        $qb = $this->createQueryBuilder('doctor');
        $qb->join('doctor.articles', 'articles');
        return $qb->getQuery()->getResult();
    }

    public function getCategories()
    {
        $result = $this->createQueryBuilder('doctors')
            ->select('DISTINCT doctors.category AS name')
            ->where('doctors.category IS NOT NULL')
            ->orderBy('name', 'ASC')
            ->getQuery()
            ->getScalarResult()
        ;
        return array_map(function($el){return $el['name'];}, $result);
    }

    // /**
    //  * @return Doctor[] Returns an array of Doctor objects
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
    public function findOneBySomeField($value): ?Doctor
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
