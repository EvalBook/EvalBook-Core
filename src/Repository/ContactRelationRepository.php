<?php

namespace App\Repository;

use App\Entity\ContactRelation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactRelation[]    findAll()
 * @method ContactRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRelationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactRelation::class);
    }

    // /**
    //  * @return ContactRelation[] Returns an array of ContactRelation objects
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
    public function findOneBySomeField($value): ?ContactRelation
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
