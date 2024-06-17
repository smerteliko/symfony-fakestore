<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit=null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    final public function findProductBy(array $options): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('product', 'price', 'currency')
            ->from(Product::class, 'product')
            ->leftJoin('product.productPrice', 'price')
            ->leftJoin('price.currency', 'currency');


        if (isset($options['id'])) {
            $qb->where('product.id = :id')
                ->setParameter('id', $options['id']);
        }

        if (isset($options['subID'])) {
            $qb->leftJoin('product.subCategory', 'sub')
                ->andWhere('sub.id = :subID')
                ->setParameter('subID', $options['subID']);
        }

        if (isset($options['catID'])) {
            $qb->leftJoin('product.Category', 'cat')
                ->andWhere('cat.id = :catID')
                ->setParameter('catID', $options['catID']);
        }

        if (isset($options['withImages'])) {
            $qb->addSelect('pI');
            $qb->leftJoin('product.productImages', 'pI');
        }

        if (isset($options['withDescriptions'])) {
            $qb->addSelect('pd');
            $qb->leftJoin('product.productDescription', 'pd');
        }

        if (isset($options['withCharacteristic'])) {
            $qb->addSelect('pC');
            $qb->leftJoin('product.productCharacteristic', 'pC');
        }

        if (isset($options['withAdditionalFields'])) {
            return $this->setAdditionalFields($qb->getQuery()->getArrayResult());
        }
        return $qb->getQuery()->getArrayResult();
    }

    private function setAdditionalFields(array $result): array
    {
        foreach ($result as $key => $oneRes) {
            $result[$key]['quantity'] = 0;
            $result[$key]['totalPrice'] = 0;
        }

        return $result;
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
