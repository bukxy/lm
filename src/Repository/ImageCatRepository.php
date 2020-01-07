<?php

namespace App\Repository;

use App\Entity\ImageCat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImageCat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageCat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageCat[]    findAll()
 * @method ImageCat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageCatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageCat::class);
    }

    // /**
    //  * @return ImageCat[] Returns an array of ImageCat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageCat
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
