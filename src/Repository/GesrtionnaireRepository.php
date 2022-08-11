<?php

namespace App\Repository;

use App\Entity\Gesrtionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gesrtionnaire>
 *
 * @method Gesrtionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gesrtionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gesrtionnaire[]    findAll()
 * @method Gesrtionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GesrtionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gesrtionnaire::class);
    }

    public function add(Gesrtionnaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gesrtionnaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Gesrtionnaire[] Returns an array of Gesrtionnaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Gesrtionnaire
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
