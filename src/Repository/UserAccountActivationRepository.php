<?php

namespace App\Repository;

use App\Entity\UserAccountActivation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserAccountActivation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAccountActivation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAccountActivation[]    findAll()
 * @method UserAccountActivation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAccountActivationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAccountActivation::class);
    }

    // /**
    //  * @return UserAccountActivation[] Returns an array of UserAccountActivation objects
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
    public function findOneBySomeField($value): ?UserAccountActivation
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
