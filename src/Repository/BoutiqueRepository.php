<?php

namespace App\Repository;

use App\Entity\Boutique;
use App\Entity\BoutiqueSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Boutique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boutique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boutique[]    findAll()
 * @method Boutique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoutiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boutique::class);
    }

     /**
      * @return Boutique[] Returns an array of Boutique objects
      */

    public function findByRecentBoutique()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Boutique[] Returns an array of Show objects
     */
    public function findByName($name){
        $query=$this->createQueryBuilder('b');
        $query->andWhere('b.nom LIKE :name');
        $query->setParameter("name", '%'.$name.'%');
        return $query->getQuery()->getResult();
    }

    /**
     * @return Boutique[] Returns an array of Show objects
     */
    public function findByBoutiqueSearch(BoutiqueSearch $search){
        $query=$this->createQueryBuilder('b');
        $query->join('b.categorieBoutiques', 'c');
        $query->andWhere('c.id = :categorie');
        $query->setParameter("categorie", $search->getCategorieBoutique());
        return $query->getQuery()->getResult();
    }
}
