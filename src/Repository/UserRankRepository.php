<?php

namespace App\Repository;

use App\Entity\UserRank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserRank|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserRank|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserRank[]    findAll()
 * @method UserRank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserRank::class);
    }

    // /**
    //  * @return UserRank[] Returns an array of UserRank objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserRank
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
