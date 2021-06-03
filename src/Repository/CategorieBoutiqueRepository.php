<?php

namespace App\Repository;

use App\Entity\CategorieBoutique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieBoutique|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieBoutique|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieBoutique[]    findAll()
 * @method CategorieBoutique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieBoutiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieBoutique::class);
    }

    // /**
    //  * @return CategorieBoutique[] Returns an array of CategorieBoutique objects
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
    public function findOneBySomeField($value): ?CategorieBoutique
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
