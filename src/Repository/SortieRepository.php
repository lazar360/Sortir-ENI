<?php

namespace App\Repository;


use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

/*
    public function findBySite($id){
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.site.id = id')
            ->orderBy('s.dateHeureDebut', 'ASC');

        $query = $qb->getQuery();

        return $query->getResult();
    }*/





     /**
      * @return Sortie[] Returns an array of Sortie objects
     */
/*    public function findBySearch($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.searchSortie = :val')
            ->setParameter('val', $value)
            ->orderBy('s.dateHeureDebut', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }*/


    /*tentative pour gérer les dates*/
    public function findByFormer($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('(s.dateHeureDebut <= now()) = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByName($val): array{
      $qb = $this->createQueryBuilder('s')
          ->setParameter('searchTerm', "%".$val."%")
          ->andWhere('s.nomSortie LIKE :searchTerm')
          ->getQuery();
    /* dd($qb->getResult());*/
     return $qb->getResult();




    }


}
