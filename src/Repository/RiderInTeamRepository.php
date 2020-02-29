<?php

namespace App\Repository;

use App\Entity\RiderInTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RiderInTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method RiderInTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method RiderInTeam[]    findAll()
 * @method RiderInTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RiderInTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RiderInTeam::class);
    }


    // /**
    //  * @return RiderInTeam[] Returns an array of RiderInTeam objects
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
    public function findOneBySomeField($value): ?RiderInTeam
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
