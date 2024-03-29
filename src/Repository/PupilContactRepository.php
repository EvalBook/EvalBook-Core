<?php

namespace EvalBookCore\Repository;

use EvalBookCore\Entity\PupilContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PupilContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method PupilContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method PupilContact[]    findAll()
 * @method PupilContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PupilContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PupilContact::class);
    }

    // /**
    //  * @return PupilContact[] Returns an array of PupilContact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PupilContact
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
