<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


	public function findProductsBy(array $options): array {
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb ->select('product')
			->from(Product::class, 'product');

		if (isset($options['id'])) {
			$qb ->where('product.id = :id')
				->setParameter('id', $options['id']);
		}

		if (isset($options['subID'])) {
			$qb ->leftJoin('product.subCategory', 'sub')
				->andWhere('sub.id = :subID')
				->setParameter('subID', $options['subID']);
		}

		if (isset($options['catID'])) {
			$qb ->leftJoin('product.Category', 'cat')
				->andWhere('cat.id = :catID')
				->setParameter('catID', $options['catID']);
		}
		$qb->addSelect('pI');
		$qb->leftJoin('product.productImages', 'pI');
		return $qb->getQuery()->getArrayResult();
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
