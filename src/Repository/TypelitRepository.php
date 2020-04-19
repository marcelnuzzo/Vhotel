<?php

namespace App\Repository;

use App\Entity\Typelit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Typelit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typelit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typelit[]    findAll()
 * @method Typelit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypelitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typelit::class);
    }

    // /**
    //  * @return Typelit[] Returns an array of Typelit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Typelit
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
