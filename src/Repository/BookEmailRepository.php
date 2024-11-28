<?php

namespace App\Repository;

use App\Entity\BookEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookEmail>
 *
 * @method BookEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookEmail[]    findAll()
 * @method BookEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookEmail::class);
    }

    public function save(BookEmail $entity, bool $flush = false): void
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
//     * @return BookEmail[] Returns an array of BookEmail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BookEmail
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
