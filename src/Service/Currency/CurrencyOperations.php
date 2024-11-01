<?php
/**
 * User: smerteliko
 * Date: 16.06.2024
 * Time: 20:51
 */

declare(strict_types=1);

namespace App\Service\Currency;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Service\Attribute\Required;

class CurrencyOperations {

	private CacheItemPoolInterface $cache;
	private            $rates = [];

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
			$this->rates = $cachedRates->get();
		}

	}


	/**
	 * @param       $sum
	 * @param       $fromCurrency
	 * @param       $toCurrency
	 * @param array $options
	 * @return mixed
	 */
	public function exchangeFromTo($sum, $fromCurrency, $toCurrency, array $options = []): mixed {
		$precision		= !empty($options['precision']) ? $options['precision'] : 2;
		$ratioPrecision	= !empty($options['ratioPrecision']) ? $options['ratioPrecision'] : 8;

		if ($fromCurrency !== $toCurrency){
			$ratio =  $this->rates[$fromCurrency]['Rate'] ?
				round(
					(float)$this->rates[$toCurrency]['Rate']
				      /
				      (float)$this->rates[$fromCurrency]['Rate'],$ratioPrecision) :
				0;
			$sum = $ratio ? round( (float)$sum * $precision ) : 0;
		}
		return $sum;
	}

	/**
	 * @param $item
	 * @return array
	 */
	public function exchangeToAllCurrencies($item): array {
		foreach ($this->rates as $rate) {
			$item['ConvertedPrice'][$rate['Currency']['IsoCode']] = $this->exchangeFromTo(
				$item['Price']??$item['price'],
				$rate['Currency']['IsoCode'],
				$item['currency']?$item['currency']['IsoCode']:840
			);
		}
		return $item;
	}
}