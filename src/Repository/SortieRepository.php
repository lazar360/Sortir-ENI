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


    /*Filtre pour gérer les dates*/
    public function findByFormer(): array
    {
        $qb = $this->createQueryBuilder('s')
            ->andWhere('(s.etat = 5)')
            ->andWhere('(s.dateHeureDebut > :end)')
            ->setParameter('end', new \DateTime('- 1 month'))
            ->getQuery();
         /*dd($qb->getResult());*/
            return $qb->getResult();
    }



    /*Filtre par mot recherché*/
    public function findByName($val): array{
        $qb = $this->createQueryBuilder('s')
            ->setParameter('searchTerm', "%".$val."%")
            ->andWhere('s.nomSortie LIKE :searchTerm')
            ->getQuery();
        /* dd($qb->getResult());*/
        return $qb->getResult();
    }

    /*Filtre par intervalle de date*/
    public function findByDates($valStart, $valEnd): array{
        $qb = $this->createQueryBuilder('s')
            ->andWhere('(s.dateHeureDebut > :start)')
            ->andWhere('(s.dateHeureDebut < :end)')
            ->setParameter('start', $valStart)
            ->setParameter('end', $valEnd)
            ->getQuery();
   /*     dd($qb->getResult());*/
        return $qb->getResult();
    }


}
