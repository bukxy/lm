<?php

namespace App\Repository;

use App\Entity\ResearchCat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ResearchCat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResearchCat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResearchCat[]    findAll()
 * @method ResearchCat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResearchCatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResearchCat::class);
    }

    // /**
    //  * @return ResearchCat[] Returns an array of ResearchCat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResearchCat
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
