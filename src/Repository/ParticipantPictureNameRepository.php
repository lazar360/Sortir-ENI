<?php

namespace App\Repository;

use App\Entity\ParticipantPictureName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParticipantPictureName|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticipantPictureName|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticipantPictureName[]    findAll()
 * @method ParticipantPictureName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantPictureNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticipantPictureName::class);
    }

    // /**
    //  * @return ParticipantPictureName[] Returns an array of ParticipantPictureName objects
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
    public function findOneBySomeField($value): ?ParticipantPictureName
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
