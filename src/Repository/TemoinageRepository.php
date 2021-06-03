<?php

namespace App\Repository;

use App\Entity\Temoinage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Temoinage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temoinage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temoinage[]    findAll()
 * @method Temoinage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemoinageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temoinage::class);
    }

     /**
      * @return Temoinage[] Returns an array of Temoinage objects
      */
    public function findByRecentTemoinage()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Temoinage[] Returns an array of Show objects
     */
    public function findByName($name){
        $query=$this->createQueryBuilder('t');
        $query->andWhere('t.objet LIKE :name');
        $query->setParameter("name", '%'.$name.'%');
        return $query->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Temoinage
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
