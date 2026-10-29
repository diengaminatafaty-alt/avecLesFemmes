<?php

namespace App\Repository;

use App\Entity\Campagne;
use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seance>
 */
class SeanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seance::class);
    }

    /**
     * Les séances d'une campagne, avec cotisations et amendes (et leurs membres).
     *
     * @return Seance[]
     */
    public function findByCampagneWithDetails(Campagne $campagne): array
    {
        return $this->createQueryBuilder('s')
                    ->leftJoin('s.cotisations', 'c')
                    ->addSelect('c')
                    ->leftJoin('c.membre', 'cm')
                    ->addSelect('cm')
                    ->leftJoin('s.amendes', 'a')
                    ->addSelect('a')
                    ->leftJoin('a.membre', 'am')
                    ->addSelect('am')
                    ->andWhere('s.campagne = :campagne')
                    ->setParameter('campagne', $campagne)
                    ->orderBy('s.dateSeanceAt', 'ASC')
                    ->getQuery()
                    ->getResult();
    }
}