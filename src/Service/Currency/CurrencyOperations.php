<?php
/**
 * User: smerteliko
 * Date: 16.06.2024
 * Time: 20:51
 */

namespace App\Service\Currency;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Service\Attribute\Required;

class CurrencyOperations {

	private CacheItemPoolInterface $cache;
	private static array           $rates = [];

	public function __construct(CacheItemPoolInterface $cache) {
		$this->cache = $cache;
	}

	/**
	 * @throws InvalidArgumentException
	 */
	#[Required]
	public function setRates(): void {
		$cachedRates = $this->cache->getItem('CurrencyRatesList');
		if($cachedRates->isHit()) {
			self::$rates = $cachedRates->get();
		}

	}


	/**
	 * @param       $sum
	 * @param       $fromCurrency
	 * @param       $toCurrency
	 * @param array $options
	 * @return mixed
	 */
	public static function exchangeFromTo($sum, $fromCurrency, $toCurrency, array $options = []): mixed {
		$precision		= !empty($options['precision']) ? $options['precision'] : 2;
		$ratioPrecision	= !empty($options['ratioPrecision']) ? $options['ratioPrecision'] : 8;

		if ($fromCurrency !== $toCurrency){
			$ratio =  self::$rates[$fromCurrency]['Rate'] ?
				round((float)self::$rates[$toCurrency]['Rate'] / (float)self::$rates[$fromCurrency]['Rate'],$ratioPrecision) :
				0;
			$sum = $ratio ? round( (float)$sum * $ratio, $precision ) : 0;
		}
		return $sum;
	}

	public static function exchangeToAllCurrencies($item): array {
		foreach (self::$rates as $rate) {
			$item['ConvertedPrice'][$rate['Currency']['IsoCode']] = self::exchangeFromTo(
				$item['Price']??$item['price'],
				$rate['Currency']['IsoCode'],
				$item['Currency']['IsoCode']??$item['currency']['IsoCode']
			);
		}
		return $item;
	}
}