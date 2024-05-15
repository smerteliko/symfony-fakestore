<?php

namespace App\Repository;

use App\Entity\UserCartItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCartItem>
 *
 * @method UserCartItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCartItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCartItem[]    findAll()
 * @method UserCartItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCartItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCartItem::class);
    }

    //    /**
    //     * @return UserCartItem[] Returns an array of UserCartItem objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserCartItem
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
