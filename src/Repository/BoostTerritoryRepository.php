<?php

namespace App\Repository;

use App\Entity\BoostTerritory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BoostTerritory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoostTerritory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoostTerritory[]    findAll()
 * @method BoostTerritory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoostTerritoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoostTerritory::class);
    }

    // /**
    //  * @return BoostTerritory[] Returns an array of BoostTerritory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BoostTerritory
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
