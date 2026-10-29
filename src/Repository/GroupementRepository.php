<?php

namespace App\Repository;

use App\Entity\Groupement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Groupement>
 */
class GroupementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groupement::class);
    }

    /**
     * Tous les groupements, avec leurs exercices chargés en une seule requête.
     *
     * @return Groupement[]
     */
    public function findAllWithExercices(): array
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.exercices', 'e')
            ->addSelect('e')
            ->orderBy('g.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}