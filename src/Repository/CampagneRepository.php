<?php

namespace App\Repository;

use App\Entity\Campagne;
use App\Entity\Groupement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Campagne>
 */
class CampagneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campagne::class);
    }

    /**
     * Les campagnes d'un groupement.
     *
     * @return Campagne[]
     */
    public function findByGroupement(Groupement $groupement): array
    {
        return $this->createQueryBuilder('c')
                    ->andWhere('c.groupement = :groupement')
                    ->setParameter('groupement', $groupement)
                    ->orderBy('c.dateDebutAt', 'DESC')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Une campagne avec ses participants (membres) chargés en une seule requête.
     */
    public function findOneWithParticipants(int $id): ?Campagne
    {
        return $this->createQueryBuilder('c')
                    ->leftJoin('c.modePayements', 'mp')
                    ->addSelect('mp')
                    ->leftJoin('mp.role', 'r')
                    ->addSelect('r')
                    ->andWhere('c.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}