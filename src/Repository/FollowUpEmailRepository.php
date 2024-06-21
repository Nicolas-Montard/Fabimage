<?php

namespace App\Repository;

use App\Entity\FollowUpEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FollowUpEmail>
 *
 * @method FollowUpEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method FollowUpEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method FollowUpEmail[]    findAll()
 * @method FollowUpEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowUpEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FollowUpEmail::class);
    }

//    /**
//     * @return FollowUpEmail[] Returns an array of FollowUpEmail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FollowUpEmail
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
