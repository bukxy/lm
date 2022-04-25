<?php

namespace App\Repository;

use App\Entity\Construction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Construction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Construction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Construction[]    findAll()
 * @method Construction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstructionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Construction::class);
    }

    // /**
    //  * @return Construction[] Returns an array of Construction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Construction
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
