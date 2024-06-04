<?php

namespace App\Repository;

use App\Entity\CurRates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * @extends ServiceEntityRepository<CurRates>
 *
 * @method CurRates|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurRates|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurRates[]    findAll()
 * @method CurRates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurRatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,
                                private readonly CurrencyRepository $currencyRepository,
                                private readonly TagAwareCacheInterface $cache)
    {
        parent::__construct($registry, CurRates::class);
    }

	/**
	 * @throws InvalidArgumentException
	 */
	public function getCurrencyRatesListCached()
	{
		return $this->cache->get('CurrencyRatesList', function (ItemInterface $item) {
			$item->tag('Currencies');
			return $this->getEntityManager()
			            ->createQueryBuilder()
			            ->select('CURRATE')
			            ->from(CurRates::class, 'CURRATE')
			            ->orderBy('CURRATE.id', 'ASC')
			            ->getQuery()
			            ->getArrayResult()
				;
		});
	}

	public function save( CurRates $currencyRateEntity): void {
		$this->getEntityManager()->persist($currencyRateEntity);
		$this->getEntityManager()->flush();
	}

	public function setCurrencyRateEntity(array $currencyRate): void {
		$currencyRateEntity = new CurRates();
		$currencyRateEntity->setRate($currencyRate['Value']);
		$currencyRateEntity->setUnitRate($currencyRate['UnitRate']);
		$currencyRateEntity->setCurrency($this->currencyRepository->find($currencyRate['NumCode']));

		$this->save($currencyRateEntity);
	}

	public function updateCurrencyRate($currencyRate): void {
		$currencyRateEntity = $this->findOneBy(['Currency' => $this->currencyRepository->find($currencyRate['NumCode'])]);
		if($currencyRateEntity) {
			$currencyRateEntity->setRate($currencyRate['Value']);
			$currencyRateEntity->setUnitRate($currencyRate['UnitRate']);
			$this->save($currencyRateEntity);
		}

	}

    //    /**
    //     * @return CurRates[] Returns an array of CurRates objects
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

    //    public function findOneBySomeField($value): ?CurRates
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
