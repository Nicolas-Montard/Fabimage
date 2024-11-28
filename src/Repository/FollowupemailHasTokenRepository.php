<?php

namespace App\Repository;

use App\Entity\FollowupemailHasToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FollowupemailHasToken>
 *
 * @method FollowupemailHasToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method FollowupemailHasToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method FollowupemailHasToken[]    findAll()
 * @method FollowupemailHasToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowupemailHasTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FollowupemailHasToken::class);
    }

    public function save(FollowupemailHasToken $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove($entity, bool $flush = false): void
{
    $this->_em->remove($entity);
    if ($flush) {
        $this->_em->flush();
    }
}

//    /**
//     * @return FollowupemailHasToken[] Returns an array of FollowupemailHasToken objects
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

//    public function findOneBySomeField($value): ?FollowupemailHasToken
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
