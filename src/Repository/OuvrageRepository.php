<?php

namespace App\Repository;


use App\Data\SearchData;
use App\Entity\Ouvrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ouvrage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ouvrage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ouvrage[]    findAll()
 * @method Ouvrage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OuvrageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ouvrage::class);
    }
    /**
     * Récupère les ouvrages en lien avec une recherche
     * @return Ouvrage[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('p');

        if (!empty($search->sites)) {
            $query = $query
                ->select('c', 'p')
                ->join('p.site', 'c')
                ->andWhere('c.id IN (:sites)')
                ->setParameter('sites', $search->sites);
        }
        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.titre LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }
        if (!empty($search->minQ)) {
            $query = $query
                ->andWhere('p.quantiteStock >= :minQ')
                ->setParameter('minQ', $search->minQ);
        }
        if (!empty($search->maxQ)) {
            $query = $query
                ->andWhere('p.quantiteStock <= :maxQ')
                ->setParameter('maxQ', $search->maxQ);
        }
        if (!empty($search->filieres)) {
            $queryf = $query
                ->select('f', 'p')
                ->join('p.filiere', 'f')
                ->andWhere('f.id IN (:filieres)')
                ->setParameter('filieres', $search->filieres);
        }
        if (!empty($search->technos)) {
            $query = $query
                ->select('t', 'p')
                ->join('p.technologie', 't')
                ->andWhere('t.id IN (:technos)')
                ->setParameter('technos', $search->technos);
        }
        return $query->getQuery()->getResult();
    }
}
