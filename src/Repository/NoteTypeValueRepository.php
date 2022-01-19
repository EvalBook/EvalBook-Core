<?php

namespace EvalBookCore\Repository;

use EvalBookCore\Entity\NoteTypeValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NoteTypeValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteTypeValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteTypeValue[]    findAll()
 * @method NoteTypeValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteTypeValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoteTypeValue::class);
    }

    // /**
    //  * @return NoteTypeValue[] Returns an array of NoteTypeValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NoteTypeValue
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
