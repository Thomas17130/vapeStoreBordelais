<?php

namespace App\Repository;

use App\Entity\EliquidProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EliquidProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method EliquidProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method EliquidProducts[]    findAll()
 * @method EliquidProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EliquidProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EliquidProducts::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(EliquidProducts $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(EliquidProducts $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return EliquidProducts[] Returns an array of EliquidProducts objects
    //  */

    public function isInStock($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.stock > :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?EliquidProducts
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
