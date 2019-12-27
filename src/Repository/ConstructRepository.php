<?php

namespace App\Repository;

use App\Entity\Construct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Construct|null find($id, $lockMode = null, $lockVersion = null)
 * @method Construct|null findOneBy(array $criteria, array $orderBy = null)
 * @method Construct[]    findAll()
 * @method Construct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstructRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Construct::class);
    }

    // /**
    //  * @return Construct[] Returns an array of Construct objects
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
    public function findOneBySomeField($value): ?Construct
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
