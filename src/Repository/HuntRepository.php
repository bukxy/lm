<?php

namespace App\Repository;

use App\Entity\Hunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Hunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hunt[]    findAll()
 * @method Hunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HuntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hunt::class);
    }

    // /**
    //  * @return Hunt[] Returns an array of Hunt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hunt
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
