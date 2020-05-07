<?php

namespace App\Repository;

use App\Entity\SiteEntreposage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SiteEntreposage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteEntreposage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteEntreposage[]    findAll()
 * @method SiteEntreposage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteEntreposageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteEntreposage::class);
    }

    // /**
    //  * @return SiteEntreposage[] Returns an array of SiteEntreposage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SiteEntreposage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
