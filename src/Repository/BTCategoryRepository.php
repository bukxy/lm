<?php

namespace App\Repository;

use App\Entity\BTCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BTCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BTCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BTCategory[]    findAll()
 * @method BTCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BTCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BTCategory::class);
    }

    // /**
    //  * @return BTCategory[] Returns an array of BTCategory objects
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
    public function findOneBySomeField($value): ?BTCategory
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
