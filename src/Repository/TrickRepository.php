<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function findFirstTricks()
    {
        return $this->findVisibleQuery()
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findTricks($offset)
    {
        return $this->findVisibleQuery()
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(5)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getTotalTricks()
    {
        return $this->findVisibleQuery()
            ->select('COUNT(t.id) AS total')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('t')
            ->where('t.validate = :val')
            ->setParameter('val', '2');
    }

    // /**
    //  * @return Trick[] Returns an array of Trick objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trick
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
