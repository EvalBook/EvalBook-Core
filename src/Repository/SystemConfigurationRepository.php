<?php

namespace App\Repository;

use App\Entity\SystemConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SystemConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method SystemConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method SystemConfiguration[]    findAll()
 * @method SystemConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SystemConfiguration::class);
    }

    // /**
    //  * @return SystemConfiguration[] Returns an array of SystemConfiguration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SystemConfiguration
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
