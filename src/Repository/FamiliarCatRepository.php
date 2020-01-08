<?php

namespace App\Repository;

use App\Entity\FamiliarCat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FamiliarCat|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamiliarCat|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamiliarCat[]    findAll()
 * @method FamiliarCat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamiliarCatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamiliarCat::class);
    }

    // /**
    //  * @return FamiliarCat[] Returns an array of FamiliarCat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FamiliarCat
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
