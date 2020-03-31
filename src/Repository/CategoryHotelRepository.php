<?php

namespace App\Repository;

use App\Entity\CategoryHotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryHotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryHotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryHotel[]    findAll()
 * @method CategoryHotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryHotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryHotel::class);
    }

    // /**
    //  * @return CategoryHotel[] Returns an array of CategoryHotel objects
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
    public function findOneBySomeField($value): ?CategoryHotel
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
