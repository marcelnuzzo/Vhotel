<?php

namespace App\Repository;

use App\Entity\CategoryRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryRoom[]    findAll()
 * @method CategoryRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryRoom::class);
    }

    // /**
    //  * @return CategoryRoom[] Returns an array of CategoryRoom objects
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
    public function findOneBySomeField($value): ?CategoryRoom
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
