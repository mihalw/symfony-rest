<?php

namespace App\Repository;

use App\Entity\RiderName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RiderName|null find($id, $lockMode = null, $lockVersion = null)
 * @method RiderName|null findOneBy(array $criteria, array $orderBy = null)
 * @method RiderName[]    findAll()
 * @method RiderName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RiderNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RiderName::class);
    }

    // /**
    //  * @return RiderName[] Returns an array of RiderName objects
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
    public function findOneBySomeField($value): ?RiderName
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
