<?php

namespace App\Repository;

use App\Entity\ProductImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * @extends ServiceEntityRepository<ProductImages>
 *
 * @method ProductImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductImages[]	findAll()
 * @method ProductImages[]	findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductImagesRepository extends ServiceEntityRepository
{
	private CacheInterface $cache;

	public function __construct(ManagerRegistry $registry , CacheInterface $cache)
	{
		parent::__construct($registry, ProductImages::class);
		$this->cache = $cache;
	}
	/**
	 */
	public function findCachedProductImagesBy(array $options): array {
			return $this->getEntityManager()->createQueryBuilder()
						->select('productImages')
						->from(ProductImages::class, 'productImages')
						->where('productImages.Product = :id')
						->setParameter('id', $options['prodId'])
						->getQuery()
						->getArrayResult();
	}

}
