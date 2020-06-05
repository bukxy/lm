<?php

namespace App\Repository;

use App\Entity\HuntCat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method HuntCat|null find($id, $lockMode = null, $lockVersion = null)
 * @method HuntCat|null findOneBy(array $criteria, array $orderBy = null)
 * @method HuntCat[]    findAll()
 * @method HuntCat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HuntCatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HuntCat::class);
    }

    // /**
    //  * @return HuntCat[] Returns an array of HuntCat objects
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
    public function findOneBySomeField($value): ?HuntCat
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
