<?php

namespace App\Repository;

use App\Entity\Marquee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Marquee>
 *
 * @method Marquee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marquee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marquee[]    findAll()
 * @method Marquee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarqueeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marquee::class);
    }

//    /**
//     * @return Marquee[] Returns an array of Marquee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Marquee
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
