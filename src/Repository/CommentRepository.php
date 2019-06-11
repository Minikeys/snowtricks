<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findFirstComments($id)
    {
        return $this->findVisibleQuery()
            ->orderBy('c.id', 'ASC')
            ->where('c.trick = :val')
            ->setParameter('val', $id)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findComments($offset, $id)
    {
        return $this->findVisibleQuery()
            ->orderBy('c.id', 'ASC')
            ->where('c.trick = :val')
            ->setParameter('val', $id)
            ->setMaxResults(5)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getTotalComments($id)
    {
        return $this->findVisibleQuery()
            ->select('COUNT(c.id) AS total')
            ->where('c.trick = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->where('c.published = :val')
            ->setParameter('val', '1');
    }
    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
