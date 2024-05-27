<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<Currency>
 *
 * @method Currency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Currency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Currency[]    findAll()
 * @method Currency[]    findBy(array $criteria, array $orderBy = null, $limit= null, $offset = null)
 */
class CurrencyRepository extends ServiceEntityRepository
{
	private CacheInterface $cache;

	public function __construct(ManagerRegistry $registry, CacheInterface $cache)
    {
        parent::__construct($registry, Currency::class);
		$this->cache = $cache;
    }

	/**
	 * @throws InvalidArgumentException
	 */
	public function getCurrencyListCached() {
		return $this->cache->get('CurrencyList', function (ItemInterface $item) {
			return $this->getEntityManager()
			            ->createQueryBuilder()
			            ->select('CUR')
			            ->from(Currency::class, 'CUR')
			            ->orderBy('CUR.id', 'ASC')
			            ->getQuery()
			            ->getArrayResult()
				;
		});
	}
    //    /**
    //     * @return Currency[] Returns an array of Currency objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Currency
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
