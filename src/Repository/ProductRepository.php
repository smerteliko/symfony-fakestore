<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;

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
	private CacheInterface $cache;

	public function __construct(ManagerRegistry $registry, CacheInterface $cache)
    {
        parent::__construct($registry, Product::class);
		$this->cache = $cache;
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
		return $this->setAdditionalFields($qb->getQuery()->getArrayResult());
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function findCachedProductDataBy(array $options) {
		return $this->cache->get('productData', function (ItemInterface $item) use ($options){
			return $this->getEntityManager()->createQueryBuilder()
				->select('product','pI')
				->from(Product::class, 'product')
				->where('product.id = :id')
				->setParameter('id', $options['id'])
				->getQuery()
				->getArrayResult();
		});
	}

	private function setAdditionalFields( array $result): array {
		foreach($result as $key=>$oneRes) {
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
